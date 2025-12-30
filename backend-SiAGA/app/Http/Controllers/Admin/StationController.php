<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StationsExport;
use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Region;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str; // [PENTING] Jangan lupa import ini

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        // Note: Pastikan nama relasi di Model Station ('impactedRegions' atau 'regions') konsisten
        $stations = Station::with(['impactedRegions'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('station_code', 'like', "%{$search}%"); // [BARU] Cari berdasarkan Kode
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.stations.index', [
            'stations' => $stations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();

        $nextStationCode = $this->generateStationCode();

        return view('admin.pages.stations.create', compact('regions', 'nextStationCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (station_code tidak perlu divalidasi karena auto-generate)
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'location'           => 'required|string|max:255',
            'latitude'           => 'required|numeric',
            'longitude'          => 'required|numeric',
            // 'water_level'        => 'required|numeric',
            // 'status'             => 'required|in:normal,siaga,awas',
            'operational_status' => 'required|in:active,non-active,maintenance', // [BARU]
            'description'        => 'nullable|string', // [BARU]
            'threshold_siaga'    => 'required|integer',
            'threshold_awas'     => 'required|integer',

            // Validasi Region
            'regions'            => 'nullable|array',
            'regions.*'          => 'exists:regions,id',
        ]);

        // 2. Siapkan data untuk disimpan (kecuali regions)
        $data = $request->except('regions');

        // [BARU] Generate Station Code otomatis
        $data['station_code'] = $this->generateStationCode();

        // 3. Buat Station baru
        $station = Station::create($data);

        // 4. Simpan relasi ke pivot table
        if ($request->has('regions')) {
            // Pastikan relasi di model Station bernama 'regions' atau sesuaikan methodnya
            $station->impactedRegions()->attach($request->regions);
        }

        return redirect()->route('stations.index')
            ->with('success', 'Pos pantau berhasil ditambahkan. Kode: ' . $station->station_code);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Sesuaikan nama relasi dengan model Anda ('regions' atau 'impactedRegions')
        $station = Station::with('impactedRegions')->findOrFail($id);
        return view('admin.pages.stations.show', compact('station'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $station = Station::with('impactedRegions')->findOrFail($id);
        $regions = Region::all();
        if ($station->has('impactedRegions')) {
            $assignedRegionIds = $station->impactedRegions->pluck('id')->toArray();
        }

        return view('admin.pages.stations.edit', compact('station', 'regions', 'assignedRegionIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $station = Station::findOrFail($id);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'location'           => 'required|string|max:255',
            'latitude'           => 'required|numeric',
            'longitude'          => 'required|numeric',
            // 'water_level'        => 'required|numeric',
            // 'status'             => 'required|in:normal,siaga,awas',
            'operational_status' => 'required|in:active,non-active,maintenance', // [BARU]
            'description'        => 'nullable|string', // [BARU]
            'threshold_siaga'    => 'required|integer',
            'threshold_awas'     => 'required|integer',

            'regions'            => 'nullable|array',
            'regions.*'          => 'exists:regions,id',
        ]);

        // 1. Update data station (station_code biasanya tidak diupdate)
        $station->update($request->except('regions'));

        // 2. Sync relasi pivot
        // Asumsi relasi di model Station bernama 'regions'
        if ($request->has('regions')) {
            $station->impactedRegions()->sync($request->regions ?? []);
        }

        return redirect()->route('stations.index')
            ->with('success', 'Data pos pantau berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $station = Station::findOrFail($id);
        $station->delete();

        return redirect()->route('stations.index')
            ->with('success', 'Pos pantau berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $fileName = 'data-pos-pantau-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new StationsExport($search, $status), $fileName);
    }

    /**
     * [BARU] Helper untuk Generate Kode Unik
     */
    private function generateStationCode()
    {
        $prefix = 'ST-' . date('Ymd') . '-';

        // Cari user terakhir yang punya prefix hari ini
        $lastStation = Station::where('station_code', 'like', $prefix . '%')
            ->orderBy('station_code', 'desc')
            ->first();

        if (!$lastStation) {
            $number = '001';
        } else {
            // Ambil 3 digit terakhir
            $lastNumber = intval(substr($lastStation->station_code, -3));
            // Tambah 1 dan pad dengan nol di kiri (misal 1 jadi 001)
            $number = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return $prefix . $number;
    }
}
