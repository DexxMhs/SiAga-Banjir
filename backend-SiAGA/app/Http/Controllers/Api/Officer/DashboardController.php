<?php

namespace App\Http\Controllers\Api\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /api/officer/dashboard
     * Menampilkan statistik untuk dashboard petugas
     */
    public function index()
    {
        $officerId = auth()->id();
        
        // Ambil stasiun yang ditugaskan
        $assignedStations = auth()->user()->assignedStations()
            ->select('stations.id', 'stations.name', 'stations.status', 'stations.water_level', 'stations.last_update')
            ->get();
        
        // Hitung laporan petugas
        $totalReports = OfficerReport::where('officer_id', $officerId)->count();
        $approvedReports = OfficerReport::where('officer_id', $officerId)
            ->where('validation_status', 'approved')
            ->count();
        $pendingReports = OfficerReport::where('officer_id', $officerId)
            ->where('validation_status', 'pending')
            ->count();
        $rejectedReports = OfficerReport::where('officer_id', $officerId)
            ->where('validation_status', 'rejected')
            ->count();
        
        // Laporan terbaru (5 terakhir)
        $recentReports = OfficerReport::with('station')
            ->where('officer_id', $officerId)
            ->latest()
            ->take(5)
            ->get();
        
        // Grafik laporan 7 hari terakhir
        $reportTrend = OfficerReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('officer_id', $officerId)
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'assigned_stations' => $assignedStations,
                'summary' => [
                    'total_reports' => $totalReports,
                    'approved' => $approvedReports,
                    'pending' => $pendingReports,
                    'rejected' => $rejectedReports,
                    'total_stations' => $assignedStations->count(),
                ],
                'recent_reports' => $recentReports,
                'report_trend' => $reportTrend,
            ]
        ]);
    }
}
