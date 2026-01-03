<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Models\OfficerReport;
use App\Models\Station;
use App\Models\Region;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Status Banjir Tertinggi (Prioritas: Awas > Siaga > Normal)
        // Cek dari Region yang statusnya 'awas'
        $highestStatus = 'Normal';
        $statusLevel = 4; // 1=Awas, 2=Siaga, 3=Waspada, 4=Normal

        $criticalRegions = Region::where('flood_status', 'awas')->count();
        $warningRegions = Region::where('flood_status', 'siaga')->count();

        if ($criticalRegions > 0) {
            $highestStatus = 'Awas';
            $statusLevel = 1;
        } elseif ($warningRegions > 0) {
            $highestStatus = 'Siaga';
            $statusLevel = 2;
        }

        // 2. Statistik Pos Pantau
        $totalStations = Station::count();
        $activeStations = Station::where('operational_status', 'active')->count();
        $stationPercentage = $totalStations > 0 ? round(($activeStations / $totalStations) * 100) : 0;

        // 3. Laporan Pending (Gabungan Petugas & Warga)
        $pendingPublic = PublicReport::where('status', 'pending')->count();
        $pendingOfficer = OfficerReport::where('validation_status', 'pending')->count();
        $totalPending = $pendingPublic + $pendingOfficer;

        // 4. Statistik Sumber Laporan (Hari Ini)
        $todayPublic = PublicReport::whereDate('created_at', Carbon::today())->count();
        $todayOfficer = OfficerReport::whereDate('created_at', Carbon::today())->count();
        $totalToday = $todayPublic + $todayOfficer;

        $publicPercentage = $totalToday > 0 ? round(($todayPublic / $totalToday) * 100) : 0;
        $officerPercentage = $totalToday > 0 ? round(($todayOfficer / $totalToday) * 100) : 0;

        // 5. Indeks Risiko (Simulasi sederhana: (Laporan Awas * 10) + (Laporan Siaga * 5))
        $riskIndex = ($criticalRegions * 10) + ($warningRegions * 5);
        // Cap max 100
        $riskIndex = min($riskIndex, 100);

        return view('admin.pages.dashboard', compact(
            'highestStatus',
            'statusLevel',
            'activeStations',
            'totalStations',
            'stationPercentage',
            'totalPending',
            'totalToday',
            'publicPercentage',
            'officerPercentage',
            'riskIndex'
        ));
    }
}
