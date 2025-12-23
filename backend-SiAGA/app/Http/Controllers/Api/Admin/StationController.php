<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AssignOfficerRequest;
use App\Http\Requests\Api\Admin\StationRequest;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    // GET /api/admin/stations
    public function index()
    {
        // Ditambahkan eager loading 'officers' agar muncul di list utama
        $stations = Station::with('officers:id,name')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $stations]);
    }

    // POST /api/admin/stations
    public function store(StationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // 1. Buat Stasiun
            $station = Station::create($request->validated());

            // 2. Jika ada petugas yang dipilih, hubungkan ke tabel pivot
            if ($request->has('officer_ids')) {
                $station->officers()->sync($request->officer_ids);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Stasiun dan penugasan petugas berhasil disimpan.',
                'data' => $station->load('officers:id,name')
            ], 201);
        });
    }

    /**
     * Menampilkan stasiun beserta daftar petugasnya
     * GET /api/admin/stations/{id}
     */
    public function show($id)
    {
        $station = Station::with('officers:id,name')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $station
        ]);
    }

    // PUT /api/admin/stations/{id}
    public function update(StationRequest $request, $id)
    {
        $station = Station::findOrFail($id);

        return DB::transaction(function () use ($request, $station) {
            // return response()->json($request);
            // 1. Update data stasiun
            $station->update($request->validated());

            // 2. Sinkronisasi petugas (Menghapus yang lama, menambah yang baru sesuai input)
            if ($request->has('officer_ids')) {
                $station->officers()->sync($request->officer_ids);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data stasiun dan penugasan petugas berhasil diperbarui.',
                'data' => $station->load('officers:id,name')
            ]);
        });
    }

    // PUT /api/admin/stations/{id}/status
    // Untuk mengubah status manual (Normal/Siaga/Awas)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:normal,siaga,awas'
        ]);

        $station = Station::findOrFail($id);
        $station->update([
            'status' => $request->status,
            'last_update' => now()
        ]);

        return response()->json(['status' => 'success', 'message' => 'Status stasiun diperbarui', 'data' => $station]);
    }

    // DELETE /api/admin/stations/{id}
    public function destroy($id)
    {
        $station = Station::findOrFail($id);

        // Disarankan menghapus relasi di pivot dulu agar database bersih
        $station->officers()->detach();
        $station->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Stasiun berhasil dihapus'
        ]);
    }

    /**
     * Memperbarui threshold (ambang batas) air untuk stasiun tertentu.
     * Endpoint: PUT /api/admin/stations/{id}/thresholds
     */
    public function updateThresholds(Request $request, $id)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'threshold_siaga' => 'required|numeric|min:0',
            'threshold_awas'  => 'required|numeric|gt:threshold_siaga', // Harus lebih besar dari siaga
        ], [
            'threshold_awas.gt' => 'Ambang batas AWAS harus lebih tinggi dari ambang batas SIAGA.'
        ]);

        // 2. Cari stasiun
        $station = Station::findOrFail($id);

        // 3. Update data threshold
        $station->update([
            'threshold_siaga' => $validated['threshold_siaga'],
            'threshold_awas'  => $validated['threshold_awas'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Ambang batas stasiun ' . $station->name . ' berhasil diperbarui.',
            'data'    => [
                'id' => $station->id,
                'name' => $station->name,
                'threshold_siaga' => $station->threshold_siaga,
                'threshold_awas' => $station->threshold_awas,
            ]
        ], 200);
    }

    /**
     * Menugaskan satu atau beberapa petugas ke sebuah stasiun.
     * PUT /api/admin/stations/{id}/assign-officers
     */
    public function assignOfficers(AssignOfficerRequest $request, $id)
    {
        $station = Station::findOrFail($id);

        // Menggunakan sync() untuk menyinkronkan tabel pivot station_user
        // sync akan menghapus petugas lama yang tidak ada di array dan menambah yang baru
        $station->officers()->sync($request->officer_ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar petugas untuk stasiun ' . $station->name . ' berhasil diperbarui.',
            'data' => $station->load('officers:id,name,role') // Menampilkan data petugas yang baru ditempelkan
        ]);
    }
}
