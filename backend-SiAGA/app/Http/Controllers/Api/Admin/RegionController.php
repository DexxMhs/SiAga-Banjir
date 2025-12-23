<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * GET /api/admin/regions [cite: 104]
     * Menampilkan semua daftar wilayah terdampak.
     */
    public function index()
    {
        $regions = Region::with('station')->latest()->get(); // Memuat info stasiun pemengaruh

        return response()->json([
            'status' => 'success',
            'data' => $regions
        ]);
    }

    /**
     * POST /api/admin/regions [cite: 105]
     * Membuat data wilayah baru.
     */
    public function store(RegionRequest $request)
    {
        $region = Region::create([
            'name' => $request->name,
            'influenced_by_station_id' => $request->influenced_by_station_id,
            'flood_status' => $request->flood_status ?? 'normal', // Default normal [cite: 37]
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Wilayah potensial berhasil ditambahkan',
            'data' => $region
        ], 201);
    }

    /**
     * PUT /api/admin/regions/{id} [cite: 106]
     * Memperbarui data wilayah.
     */
    public function update(RegionRequest $request, $id)
    {
        $region = Region::findOrFail($id);

        $region->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data wilayah berhasil diperbarui',
            'data' => $region
        ]);
    }
}
