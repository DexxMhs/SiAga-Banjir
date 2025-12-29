<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\DisasterFacility;
use Illuminate\Http\Request;

class DisasterFacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = DisasterFacility::query();

        // 1. Filter berdasarkan Tipe (misal user cuma mau cari Dapur Umum)
        // URL: /api/facilities?type=dapur_umum
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 2. Filter status (misal cuma cari yang 'buka')
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data
        $facilities = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas bencana berhasil diambil',
            'data' => $facilities
        ]);
    }

    // Detail satu lokasi
    public function show($id)
    {
        $facility = DisasterFacility::find($id);

        if (!$facility) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $facility
        ]);
    }
}
