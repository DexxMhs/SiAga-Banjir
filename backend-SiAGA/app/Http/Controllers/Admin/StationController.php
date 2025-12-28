<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StationsExport;
use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $stations = Station::with(['officers:id,name', 'impactedRegions:id,name']) // Update 1: Load relasi wilayah terdampak
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10) // Biasanya 10 lebih pas daripada 5
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
        return view('admin.pages.stations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Update 2: Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'water_level' => 'required|numeric',
            'status' => 'required|in:normal,siaga,awas',
            'threshold_siaga' => 'required|integer',
            'threshold_awas' => 'required|integer',
        ]);

        Station::create($validated);

        // Update 3: Redirect dengan Pesan Sukses
        return redirect()->route('stations.index')
            ->with('success', 'Pos pantau berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Biasanya jarang dipakai kalau sudah ada index lengkap,
        // tapi bisa buat lihat detail history
        $station = Station::with('impactedRegions')->findOrFail($id);
        return view('admin.pages.stations.show', compact('station'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $station = Station::findOrFail($id);
        return view('admin.pages.stations.edit', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $station = Station::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'water_level' => 'required|numeric',
            'status' => 'required|in:normal,siaga,awas',
            'threshold_siaga' => 'required|integer',
            'threshold_awas' => 'required|integer',
        ]);

        $station->update($validated);

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
}
