<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicReportController extends Controller
{
    /**
     * POST /api/public/report
     * Laporan rutin warga tentang kondisi banjir di lokasi mereka.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location'     => 'required|string', // Alamat atau deskripsi lokasi
            'water_height' => 'required|numeric', // Tinggi air dalam cm
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Inisialisasi data untuk disimpan
        $data = [
            'user_id'      => Auth::id(),
            'location'     => $validated['location'],
            'water_height' => $validated['water_height'],
            'status'       => 'pending', // Status default sebelum diverifikasi admin
        ];

        // Logika upload foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public_reports', 'public');
            $data['photo'] = $path;
        }

        $report = PublicReport::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan Anda berhasil dikirim dan sedang menunggu verifikasi.',
            'data'    => $report
        ], 201);
    }

    /**
     * POST /api/public/emergency-report
     * Laporan Darurat (SOS)
     */
    public function emergency(Request $request)
    {
        // Untuk darurat, kita bisa langsung set status 'emergency' atau tinggi air maksimal
        $report = PublicReport::create([
            'user_id'      => Auth::id(),
            'location'     => $request->location ?? 'Lokasi tidak spesifik (SOS Klik)',
            'water_height' => 0, // Bisa diabaikan untuk SOS
            'status'       => 'emergency',
            'photo'        => null
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Sinyal darurat telah dikirim ke pusat kendali! Petugas akan segera merespon.',
            'data'    => $report
        ]);
    }

    /**
     * GET /api/public/area-status
     * Melihat status banjir berdasarkan wilayah domisili user.
     */
    public function areaStatus()
    {
        $user = Auth::user();

        if (!$user->region_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan lengkapi profil Anda dengan memilih wilayah domisili.'
            ], 400);
        }

        // Ambil data wilayah beserta stasiun yang mempengaruhinya
        $region = Region::with('station')->find($user->region_id);

        if (!$region || !$region->station) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data stasiun pemantau untuk wilayah Anda belum tersedia.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'region_name'  => $region->name,
                'status'       => $region->station->status,
                'water_level'  => $region->station->water_level,
                'station_name' => $region->station->name,
                'last_update'  => $region->station->last_update
            ]
        ]);
    }
}
