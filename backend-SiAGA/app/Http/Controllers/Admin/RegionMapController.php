<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Station;
use Illuminate\Http\Request;

class RegionMapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // filter: normal, siaga, awas

        // 1. Query Dasar
        $query = Region::with('relatedStations') // Eager load relasi pivot
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->when($status, function ($q) use ($status) {
                $q->where('flood_status', $status);
            });

        // 2. Data untuk List Sidebar (Paginated)
        // Kita clone query agar tidak bentrok dengan map data
        $regions = (clone $query)->latest()->paginate(10)->withQueryString();

        // 3. Data untuk Peta (Semua data, tanpa paginasi)
        // Kita perlu mapping agar formatnya sesuai dengan JS Leaflet
        $mapData = (clone $query)->get()->map(function ($region) {
            return [
                'id' => $region->id,
                'name' => $region->name,
                'lat' => $region->latitude,
                'lng' => $region->longitude,
                'status' => $region->flood_status, // Untuk warna marker
                'note' => $region->risk_note,
                // Mengambil nama-nama stasiun penyebab banjir
                'influenced_by' => $region->relatedStations->pluck('name')->join(', '),
            ];
        });

        // dd($mapData);

        // 4. Statistik untuk Filter Chips (Hitung jumlah per status)
        $stats = [
            'all' => Region::count(),
            'awas' => Region::where('flood_status', 'awas')->count(),
            'siaga' => Region::where('flood_status', 'siaga')->count(),
            'normal' => Region::where('flood_status', 'normal')->count(),
        ];

        return view('admin.pages.region-map.index', compact('regions', 'mapData', 'stats'));
    }
}
