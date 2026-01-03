<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterFacility;
use App\Models\PublicReport;
use App\Models\Region;
use App\Models\Station;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::all();
        $stations = Station::all();
        $facilities = DisasterFacility::all();

        // [BARU] Ambil laporan aktif (kecuali yang sudah selesai)
        $reports = PublicReport::with('user')
            ->whereIn('status', ['pending', 'diproses', 'emergency'])
            ->get();

        $mapData = [
            // ... (regions, stations, facilities code tetap sama) ...
            'regions' => $regions->map(function ($item) {
                // ... code lama ...
                return [
                    'type' => 'region',
                    'id' => $item->id,
                    'name' => $item->name,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'status' => $item->flood_status,
                    'note' => $item->risk_note,
                    'influenced_by' => $item->relatedStations->pluck('name')->join(', '),
                ];
            }),
            'stations' => $stations->map(function ($item) {
                // ... code lama ...
                return [
                    'type' => 'station',
                    'id' => $item->id,
                    'name' => $item->name,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'status' => $item->status,
                    'water_level' => $item->water_level,
                    'location' => $item->location
                ];
            }),
            'facilities' => $facilities->map(function ($item) {
                // ... code lama ...
                return [
                    'type' => 'facility',
                    'id' => $item->id,
                    'name' => $item->name,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'status' => $item->status,
                    'facility_type' => $item->type,
                    'address' => $item->address
                ];
            }),

            // [BARU] Data Laporan Masyarakat
            'reports' => $reports->map(function ($item) {
                return [
                    'type' => 'report',
                    'id' => $item->id,
                    'code' => $item->report_code,
                    'reporter_name' => $item->user->name ?? 'Anonim',
                    'location' => $item->location,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'water_level' => $item->water_level, // Laporan warga ada tinggi air
                    'status' => $item->status, // pending, diproses, emergency
                    'note' => $item->note,
                    'photo' => $item->photo, // Path foto
                    'time_ago' => $item->created_at->diffForHumans()
                ];
            }),
        ];

        return view('admin.pages.map.index', compact('mapData'));
    }
}
