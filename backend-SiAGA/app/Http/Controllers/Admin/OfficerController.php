<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $stationId = $request->input('station_id'); // Kita filter berdasarkan stasiun yang ditugaskan

        $officers = User::where('role', 'petugas')
            ->with('assignedStations:id,name')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->when($stationId, function ($query, $stationId) {
                // Memfilter petugas yang ditugaskan di stasiun tertentu
                $query->whereHas('assignedStations', function ($q) use ($stationId) {
                    $q->where('stations.id', $stationId);
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // Statistik
        $stats = [
            'total' => User::where('role', 'petugas')->count(),
            'assigned' => User::where('role', 'petugas')->whereHas('assignedStations')->count(),
            'unassigned' => User::where('role', 'petugas')->whereDoesntHave('assignedStations')->count(),
        ];

        // Ambil daftar stasiun untuk dropdown filter
        $stations = \App\Models\Station::select('id', 'name')->get();

        return view('admin.pages.officers.index', compact('officers', 'stats', 'stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
