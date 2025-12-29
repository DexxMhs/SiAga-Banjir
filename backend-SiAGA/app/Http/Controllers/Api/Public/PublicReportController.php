<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PublicReportController extends Controller
{
    private function generateReportCode($type)
    {
        $today = Carbon::now()->format('Ymd');

        if ($type == "sos") {
            $prefix = "SOS-{$today}";
        } elseif ($type == "biasa") {
            $prefix = "RPT-{$today}";
        }
        // Cari laporan terakhir yang dibuat HARI INI
        $lastReport = PublicReport::where('report_code', 'like', "{$prefix}-%")
            ->orderBy('id', 'desc')
            ->first();

        // Jika belum ada laporan hari ini, mulai dari 001
        if (!$lastReport) {
            $number = '001';
        } else {
            // Ambil 3 digit terakhir dari kode laporan terakhir
            $lastNumber = (int) substr($lastReport->report_code, -3);
            // Tambah 1 dan pad dengan nol di kiri
            $number = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return "{$prefix}-{$number}";
    }
    /**
     * POST /api/public/report
     * Laporan rutin warga tentang kondisi banjir di lokasi mereka.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Sesuaikan dengan Schema Database)
        $validated = $request->validate([
            'location'    => 'required|string|max:255',
            'latitude'    => 'required|numeric|between:-90,90',   // Wajib untuk peta
            'longitude'   => 'required|numeric|between:-180,180', // Wajib untuk peta
            'water_level' => 'required|numeric|min:0',            // Menggunakan water_level sesuai DB
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'note'        => 'nullable|string',
        ]);

        $reportCode = $this->generateReportCode("biasa");

        // 2. Upload Foto (Jika ada)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Simpan di folder: storage/app/public/reports/YYYY-MM
            $folder = 'reports/' . date('Y-m');
            $photoPath = $request->file('photo')->store($folder, 'public');
        }

        // 3. Simpan ke Database
        $report = PublicReport::create([
            // Generate kode unik: RPT-TIMESTAMP-RANDOM (Contoh: RPT-170123-A1B2)
            'report_code' => $reportCode,
            'user_id'     => Auth::id(),
            'location'    => $validated['location'],
            'latitude'    => $validated['latitude'],
            'longitude'   => $validated['longitude'],
            'water_level' => $validated['water_level'],
            'note'        => $request->note ?? null,
            'photo'       => $photoPath,
            'status'      => 'pending', // Default status
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan berhasil dikirim. Menunggu verifikasi petugas.',
            'data'    => $report
        ], 201);
    }

    /**
     * POST /api/public/emergency-report
     * Laporan Darurat (Tombol SOS)
     */
    public function emergency(Request $request)
    {
        // Untuk SOS, koordinat SANGAT PENTING agar tim SAR tahu lokasi
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'location'  => 'nullable|string', // Opsional, bisa auto-detect di frontend
        ]);

        $reportCode = $this->generateReportCode("sos");

        $report = PublicReport::create([
            'report_code' => $reportCode,
            'user_id'     => Auth::id(),
            // Jika user panik dan tidak isi lokasi teks, kita isi default
            'location'    => $request->location ?? 'Sinyal Darurat (Koordinat Terlampir)',
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'water_level' => 0, // Default 0 atau estimasi tinggi (misal 100cm) agar trigger alert
            'note'        => 'PANGGILAN DARURAT / SOS',
            'status'      => 'emergency', // Langsung set status emergency
            'photo'       => null
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'SINYAL SOS DITERIMA! Petugas telah disiagakan ke lokasi anda.',
            'data'    => $report
        ], 201);
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
