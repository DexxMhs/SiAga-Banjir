<?php

namespace App\Http\Controllers\Api\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerReport;
use App\Http\Requests\Api\OfficerReportRequest;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficerReportController extends Controller
{
    public function store(OfficerReportRequest $request)
    {
        $validated = $request->validated();

        // Upload foto bukti lapangan
        $path = $request->file('photo')->store('officer_reports', 'public');

        // Simpan data laporan petugas dengan status pending
        $report = OfficerReport::create([
            'officer_id'        => auth()->id(),
            'station_id'        => $validated['station_id'],
            'water_level'       => $validated['water_level'],
            'rainfall'          => $validated['rainfall'],
            'pump_status'       => $validated['pump_status'],
            'photo'             => $path,
            'note'              => $validated['note'] ?? null,
            'validation_status' => 'pending', // Menunggu persetujuan Admin
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan teknis berhasil dikirim. Menunggu validasi Admin.',
            'data'    => $report
        ], 201);
    }

    // Melihat riwayat laporan pribadi petugas
    public function index()
    {
        $reports = OfficerReport::where('officer_id', auth()->id())
            ->with('station')
            ->latest()
            ->get();

        return response()->json(['data' => $reports]);
    }

    // Melihat detail laporan pribadi petugas
    public function show($id)
    {
        // Cari laporan berdasarkan ID dan pastikan milik petugas yang sedang login
        // Serta muat informasi stasiun terkait
        $report = OfficerReport::with('station')
            ->where('officer_id', auth()->id())
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $report
        ], 200);
    }

    /**
     * Menampilkan daftar semua stasiun untuk dipilih petugas.
     * Endpoint: GET /api/officer/stations
     */
    public function getStations()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil hanya stasiun yang ditugaskan ke user ini
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
