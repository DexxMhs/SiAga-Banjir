<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Station;
use Illuminate\Http\Request;

class RegionController extends Controller
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

        return view('admin.pages.regions.index', compact('regions', 'mapData', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua stasiun untuk dipilih di form (Multiselect)
        $stations = Station::all();
        return view('admin.pages.regions.create', compact('stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'flood_status' => 'required|in:normal,siaga,awas',
            'risk_note' => 'nullable|string',
            // Validasi input array stasiun (pivot)
            'stations' => 'nullable|array',
            'stations.*' => 'exists:stations,id',
        ]);

        $region = Region::create($validated);

        // Simpan Relasi Pivot (Stasiun yang mempengaruhi wilayah ini)
        if ($request->has('stations')) {
            // Attach stasiun yang dipilih
            $region->relatedStations()->attach($request->stations);
        }

        return redirect()->route('regions.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::with('relatedStations')->findOrFail($id);
        return view('admin.pages.regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::with('relatedStations')->findOrFail($id);
        $stations = Station::all();

        return view('admin.pages.regions.edit', compact('region', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $region = Region::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'flood_status' => 'required|in:normal,siaga,awas',
            'risk_note' => 'nullable|string',
            'stations' => 'nullable|array',
        ]);

        $region->update($validated);

        // Update Relasi Pivot (Sync akan menghapus yang lama dan pasang yang baru)
        if ($request->has('stations')) {
            $region->relatedStations()->sync($request->stations);
        } else {
            // Jika user uncheck semua stasiun
            $region->relatedStations()->detach();
        }

        return redirect()->route('regions.index')->with('success', 'Data wilayah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->route('regions.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
