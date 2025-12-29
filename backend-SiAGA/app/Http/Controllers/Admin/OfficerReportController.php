<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficerReport;
use App\Models\Station;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\OfficerReportsExport;
use App\Notifications\PublicFloodAlert;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class OfficerReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Dasar dengan Eager Loading (Optimasi Query)
        $query = OfficerReport::with(['officer', 'station'])->latest();

        // 2. Filter Pencarian (Nama Petugas, Nama Stasiun, ID Laporan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhereHas('officer', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('station', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        // 3. Filter Status Validasi
        if ($request->filled('status') && $request->status != 'Semua Status') {
            $statusMap = [
                'Terverifikasi' => 'approved',
                'Menunggu' => 'pending',
                'Ditolak' => 'rejected'
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('validation_status', $statusMap[$request->status]);
            }
        }

        // 4. Filter Waktu (Dropdown)
        if ($request->filled('date')) {
            switch ($request->date) {
                case '24 Jam Terakhir':
                    $query->where('created_at', '>=', Carbon::now()->subDay());
                    break;
                case 'Minggu Ini':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'Bulan Ini':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
            }
        }

        // 5. Eksekusi Pagination
        $reports = $query->paginate(10)->withQueryString();

        // 6. Hitung Statistik untuk Cards (Query Ringan)
        $stats = [
            'total_today' => OfficerReport::whereDate('created_at', Carbon::today())->count(),
            'pending'     => OfficerReport::where('validation_status', 'pending')->count(),
            'awas'     => OfficerReport::where('calculated_status', 'awas')->count(), // Asumsi 'awas' = Siaga 1
            'verified'    => OfficerReport::where('validation_status', 'approved')->count(),
        ];

        // 7. Data Stasiun untuk Filter Dropdown (Opsional jika ingin filter by station)
        $stations = Station::select('id', 'name')->get();

        return view('admin.pages.officer-reports.index', compact('reports', 'stats', 'stations'));
    }

    public function show(string $id)
    {
        $report = OfficerReport::with(['officer', 'station', 'validator'])->findOrFail($id);
        return view('admin.pages.officer-reports.show', compact('report'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Eager Load 'station.impactedRegions' untuk akses data wilayah terkait
        $report = OfficerReport::with('station.impactedRegions')->findOrFail($id);

        $request->validate([
            'validation_status' => 'required|in:approved,rejected',
            'admin_note'        => 'nullable|string|max:1000',
        ]);

        // 2. Update Data Laporan
        $report->update([
            'validation_status' => $request->validation_status,
            'admin_note'        => $request->admin_note,
            'validated_by'      => auth()->id(),
        ]);

        // 3. Logika Update Station & Region (Hanya jika disetujui)
        if ($request->validation_status == 'approved' && $report->station) {

            // A. Update Station
            $report->station->update([
                'water_level' => $report->water_level,
                'status'      => $report->calculated_status,
                'last_update' => Carbon::now()
            ]);

            // B. Update Wilayah Terdampak & KIRIM NOTIFIKASI WARGA
            if ($report->station->impactedRegions->isNotEmpty()) {

                foreach ($report->station->impactedRegions as $region) {

                    // Simpan status lama (untuk cek apakah status berubah)
                    $oldStatus = $region->flood_status;
                    $newStatus = $report->calculated_status;

                    // Update database region
                    $region->update([
                        'flood_status' => $newStatus
                    ]);

                    // --- LOGIC KIRIM NOTIFIKASI KE WARGA ---

                    // Kita hanya kirim notif jika statusnya berbahaya (Siaga/Awas)
                    // Atau jika statusnya BERUBAH (misal dari Normal -> Siaga)
                    // $isDangerous = in_array($newStatus, ['siaga', 'awas']);
                    // $isChanged = $oldStatus != $newStatus;

                    // if ($isDangerous || $isChanged) {
                    //     try {
                    //         // Kita panggil notify() LANGSUNG ke object Region
                    //         // Karena di langkah 2 tadi Region sudah kita kasih trait Notifiable
                    //         $region->notify(new PublicFloodAlert($newStatus, $region->name));
                    //     } catch (\Exception $e) {
                    //         Log::error("Gagal broadcast ke warga region {$region->id}: " . $e->getMessage());
                    //     }
                    // }
                }
            }
        }

        $statusMsg = $request->validation_status == 'approved' ? 'disetujui' : 'ditolak';

        return redirect()->route('officer-reports.show', $id)
            ->with('success', "Laporan berhasil $statusMsg, data stasiun dan wilayah telah diperbarui.");
    }

    public function export(Request $request)
    {
        // Generate nama file dengan tanggal
        $fileName = 'laporan-petugas-' . date('Y-m-d_H-i') . '.xlsx';

        // Download Excel dengan mengirimkan request filter ke class Export
        return Excel::download(new OfficerReportsExport($request), $fileName);
    }

    public function print(string $id)
    {
        // Ambil data laporan beserta relasinya
        $report = OfficerReport::with(['officer', 'station', 'validator'])->findOrFail($id);

        // Load view khusus untuk cetak (kita buat di langkah 3)
        $pdf = Pdf::loadView('admin.pages.officer-reports.print', compact('report'));

        // Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Stream (tampilkan di browser) atau Download
        // Menggunakan stream agar user bisa melihat preview dulu sebelum print fisik
        return $pdf->stream('Laporan-Petugas-' . $report->report_code . '.pdf');
    }
}
