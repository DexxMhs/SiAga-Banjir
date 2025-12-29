<?php

namespace App\Http\Controllers\Api\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerReport;
use App\Http\Requests\Api\OfficerReportRequest;
use App\Models\Station; // Pastikan model Station di-import untuk hitung status otomatis (opsional)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Import Carbon untuk tanggal

class OfficerReportController extends Controller
{
    /**
     * Format ID: RPT-YYYYMMDD-XXX
     * Contoh: RPT-20251228-001
     */
    private function generateReportCode()
    {
        $today = Carbon::now()->format('Ymd');
        $prefix = "RPT-{$today}";

        // Cari laporan terakhir yang dibuat HARI INI
        $lastReport = OfficerReport::where('report_code', 'like', "{$prefix}-%")
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

    public function store(OfficerReportRequest $request)
    {
        $validated = $request->validated();

        // 1. Generate Kode Laporan Otomatis
        $reportCode = $this->generateReportCode();

        // 2. Upload foto bukti lapangan
        $path = $request->file('photo')->store('officer_reports', 'public');

        // 3. (Opsional) Hitung Status Otomatis (Awas/Siaga/Normal)
        // Sebaiknya status dihitung sistem, bukan inputan manual petugas agar akurat
        $station = Station::findOrFail($validated['station_id']);
        $calculatedStatus = 'normal';
        if ($validated['water_level'] >= $station->threshold_awas) {
            $calculatedStatus = 'awas';
        } elseif ($validated['water_level'] >= $station->threshold_siaga) {
            $calculatedStatus = 'siaga';
        }

        // 4. Simpan data laporan
        $report = OfficerReport::create([
            'report_code'       => $reportCode, // Input kode otomatis
            'officer_id'        => auth()->id(),
            'station_id'        => $validated['station_id'],
            'water_level'       => $validated['water_level'],
            'rainfall'          => $validated['rainfall'],
            'pump_status'       => $validated['pump_status'],
            'photo'             => $path,
            'note'              => $validated['note'] ?? null,
            'calculated_status' => $calculatedStatus, // Simpan status hasil hitungan
            'validation_status' => 'pending',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan teknis berhasil dikirim. Kode: ' . $reportCode,
            'data'    => $report
        ], 201);
    }

    public function index()
    {
        $reports = OfficerReport::where('officer_id', auth()->id())
            ->with('station')
            ->latest()
            ->get();

        return response()->json(['data' => $reports]);
    }

    public function show($id)
    {
        // Bisa cari berdasarkan ID atau REPORT_CODE
        $report = OfficerReport::with('station')
            ->where('officer_id', auth()->id())
            ->where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('report_code', $id);
            })
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data'   => $report
        ], 200);
    }

    public function getStations()
    {
        $user = Auth::user();

        $stations = $user->assignedStations()
            ->select('stations.id', 'stations.name', 'stations.location', 'stations.status')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => $stations->isEmpty()
                ? 'Anda belum ditugaskan ke stasiun manapun.'
                : 'Daftar stasiun tugas berhasil diambil.',
            'data'    => $stations
        ]);
    }
}
