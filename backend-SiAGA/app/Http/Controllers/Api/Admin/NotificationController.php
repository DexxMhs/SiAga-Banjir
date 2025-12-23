<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationSettingRule;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    protected $notifService;

    public function __construct(NotificationService $notifService)
    {
        $this->notifService = $notifService;
    }

    /**
     * GET /api/admin/notifications/rules
     * Melihat daftar template pesan (Siaga & Awas)
     */
    public function getRules()
    {
        $rules = NotificationSettingRule::all();
        return response()->json([
            'status' => 'success',
            'data' => $rules
        ]);
    }

    /**
     * PUT /api/admin/notifications/rules/{id}
     * Mengubah isi template pesan
     */
    public function updateRule(Request $request, $id)
    {
        $request->validate([
            'message_template' => 'required|string|min:10',
        ]);

        $rule = NotificationSettingRule::findOrFail($id);
        $rule->update([
            'message_template' => $request->message_template
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Template pesan ' . $rule->status_type . ' berhasil diperbarui',
            'data' => $rule
        ]);
    }

    /**
     * POST /api/admin/notifications/broadcast
     * Mengirim pesan manual ke warga.
     */
    public function broadcast(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:100',
            'message'   => 'required|string',
            'region_id' => 'nullable|exists:regions,id', // Jika null, kirim ke semua warga
        ]);

        return DB::transaction(function () use ($validated) {
            // 1. Ambil daftar user target (hanya role public)
            $query = User::where('role', 'public')->whereNotNull('notification_token');

            if (!empty($validated['region_id'])) {
                $query->where('region_id', $validated['region_id']);
            }

            $targetUsers = $query->get();
            $tokens = $targetUsers->pluck('notification_token')->toArray();

            if ($targetUsers->isEmpty()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Tidak ada warga ditemukan di wilayah tersebut.'
                ], 404);
            }

            // 2. Simpan riwayat ke database (Bulk Insert agar cepat)
            $notificationData = $targetUsers->map(function ($user) use ($validated) {
                return [
                    'user_id'    => $user->id,
                    'title'      => $validated['title'],
                    'message'    => $validated['message'],
                    'type'       => 'broadcast_manual',
                    'data'       => json_encode(['region_id' => $validated['region_id'] ?? 'all']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            Notification::insert($notificationData);

            // 3. Kirim Push Notification melalui Firebase
            $this->notifService->sendNotification(
                $tokens,
                $validated['title'],
                $validated['message'],
                ['type' => 'broadcast_manual']
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Broadcast berhasil dikirim ke ' . count($tokens) . ' warga.'
            ]);
        });
    }
}
