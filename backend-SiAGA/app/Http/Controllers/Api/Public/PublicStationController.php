<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Region;
use Illuminate\Http\Request;

class PublicStationController extends Controller
{
    // GET /api/stations
    public function index()
    {
        // Eager load regions agar warga tahu wilayah mana yang terdampak stasiun ini
        $stations = Station::with('regions:id,name,influenced_by_station_id')
            ->select('id', 'name', 'location', 'latitude', 'longitude', 'water_level', 'status', 'last_update')
            ->get();

        return response()->json(['status' => 'success', 'data' => $stations]);
    }

    // GET /api/stations/{id}
    public function show($id)
    {
        $station = Station::with('regions:id,name,influenced_by_station_id')
            ->select('id', 'name', 'location', 'latitude', 'longitude', 'water_level', 'status', 'last_update')
            ->findOrFail($id);

        return response()->json(['status' => 'success', 'data' => $station]);
    }

    // GET /api/regions
    public function regions()
    {
        $regions = Region::with('station:id,name,status')->get();
        return response()->json(['status' => 'success', 'data' => $regions]);
    }
}
