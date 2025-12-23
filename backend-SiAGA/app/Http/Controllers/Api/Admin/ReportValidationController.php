<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RejectReportRequest;
use App\Models\Notification;
use App\Models\NotificationSettingRule;
use App\Models\OfficerReport;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportValidationController extends Controller
{
    public function approve(Request $request, $id, NotificationService $notificationService)
    {
        // 1. Eager load station, regions, dan users (hanya role public) untuk efisiensi
        $report = OfficerReport::with(['station.regions.users' => function ($q) {
            $q->where('role', 'public');
        }])->findOrFail($id);

        $station = $report->station;

        return DB::transaction(function () use ($report, $station, $notificationService) {

            // 2. LOGIKA PENENTUAN STATUS DINAMIS
            $newStatus = 'normal';
            if ($report->water_level >= $station->threshold_awas) {
                $newStatus = 'awas';
            } elseif ($report->water_level >= $station->threshold_siaga) {
                $newStatus = 'siaga';
            }

            // 3. Update laporan petugas
            $report->update([
                'validation_status' => 'approved',
                'calculated_status' => $newStatus,
                'validated_by'      => auth()->id(),
            ]);

            // 4. Update data stasiun
            $station->update([
                'water_level' => $report->water_level,
                'status'      => $newStatus,
                'last_update' => now(),
            ]);

            // 4.5 UPDATE STATUS REGION TERDAMPAK
            // Mengubah status semua wilayah yang terhubung dengan stasiun ini
            DB::table('regions')
                ->where('influenced_by_station_id', $station->id)
                ->update([
                    'flood_status' => $newStatus,
                    'updated_at' => now()
                ]);

            // 5. LOGIKA NOTIFIKASI (Hanya jika Siaga/Awas)
            if (in_array($newStatus, ['siaga', 'awas'])) {

                // Ambil template pesan dari DB
                $rule = NotificationSettingRule::where('status_type', $newStatus)->first();

                $title = "⚠️ PERINGATAN BANJIR: STATUS " . strtoupper($newStatus);
                $body = $rule
                    ? $rule->formatMessage($station->name, $newStatus)
                    : "Pos Pantau {$station->name} terpantau {$report->water_level}cm. Harap waspada!";

                // Ambil semua user terdampak dari relasi yang sudah di-load
                $impactedUsers = $station->regions->flatMap->users;

                // Koleksi token untuk Firebase
                $tokens = $impactedUsers->whereNotNull('notification_token')->pluck('notification_token')->toArray();

                if ($impactedUsers->isNotEmpty()) {
                    // Simpan riwayat ke database secara massal (Bulk Insert) untuk performa lebih baik
                    $notificationData = $impactedUsers->map(function ($user) use ($title, $body, $station) {
                        return [
                            'user_id'    => $user->id,
                            'title'      => $title,
                            'message'    => $body,
                            'type'       => 'flood_alert',
                            'data'       => json_encode(['station_id' => $station->id]),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();

                    Notification::insert($notificationData);
                }

                // Kirim ke Firebase jika ada token aktif
                if (!empty($tokens)) {
                    $notificationService->sendNotification($tokens, $title, $body, [
                        'type' => 'flood_alert',
                        'station_id' => (string) $station->id
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Laporan disetujui dengan status: ' . $newStatus . ($newStatus != 'normal' ? ' & notifikasi telah dikirim.' : '.')
            ]);
        });
    }

    public function reject(RejectReportRequest $request, $id)
    {
        // 1. Cari laporan yang masih berstatus pending [cite: 97]
        $report = OfficerReport::where('validation_status', 'pending')->findOrFail($id);

        // 2. Update status laporan menjadi rejected
        $report->update([
            'validation_status' => 'rejected',
            'validated_by'      => auth()->id(),
            'note'              => 'DITOLAK ADMIN: ' . $request->note, // Menambahkan alasan ke catatan
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan petugas telah ditolak.',
            'data'    => $report
        ], 200);
    }

    public function index()
    {
        // Mengambil laporan dengan status pending, urutkan dari yang terbaru
        $reports = OfficerReport::with(['officer', 'station'])
            ->where('validation_status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar laporan petugas berhasil diambil',
            'data' => $reports
        ], 200);
    }
}
