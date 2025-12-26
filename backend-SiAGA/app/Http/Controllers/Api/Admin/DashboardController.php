<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficerReport;
use App\Models\PublicReport;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /api/admin/dashboard
     * Menampilkan statistik untuk dashboard admin
     */
    public function index()
    {
        // Hitung statistik
        $totalStations = Station::count();
        $totalOfficers = User::where('role', 'petugas')->count();
        $totalPublicUsers = User::where('role', 'public')->count();
        
        // Hitung laporan
        $pendingOfficerReports = OfficerReport::where('validation_status', 'pending')->count();
        $pendingPublicReports = PublicReport::where('status', 'pending')->count();
        $emergencyReports = PublicReport::where('status', 'emergency')->count();
        
        // Status stasiun
        $stationsByStatus = Station::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');
        
        // Laporan terbaru (5 terakhir)
        $recentOfficerReports = OfficerReport::with(['officer', 'station'])
            ->where('validation_status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        $recentPublicReports = PublicReport::with(['user'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        // Grafik laporan 7 hari terakhir
        $reportTrend = OfficerReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => [
                    'total_stations' => $totalStations,
                    'total_officers' => $totalOfficers,
                    'total_public_users' => $totalPublicUsers,
                    'pending_officer_reports' => $pendingOfficerReports,
                    'pending_public_reports' => $pendingPublicReports,
                    'emergency_reports' => $emergencyReports,
                ],
                'station_status' => [
                    'normal' => $stationsByStatus['normal'] ?? 0,
                    'siaga' => $stationsByStatus['siaga'] ?? 0,
                    'awas' => $stationsByStatus['awas'] ?? 0,
                ],
                'recent_officer_reports' => $recentOfficerReports,
                'recent_public_reports' => $recentPublicReports,
                'report_trend' => $reportTrend,
            ]
        ]);
    }

    /**
     * GET /api/admin/dashboard/flood-potential
     * Menampilkan daftar wilayah berpotensi banjir dengan statusnya
     */
    public function floodPotential()
    {
        $regions = DB::table('regions')
            ->join('stations', 'regions.influenced_by_station_id', '=', 'stations.id')
            ->select(
                'regions.id',
                'regions.name as region_name',
                'regions.flood_status',
                'stations.name as station_name',
                'stations.water_level',
                'stations.status as station_status',
                'stations.last_update'
            )
            ->orderByRaw("
                CASE regions.flood_status
                    WHEN 'awas' THEN 1
                    WHEN 'siaga' THEN 2
                    WHEN 'normal' THEN 3
                END
            ")
            ->get();

        // Hitung ringkasan per status
        $summary = DB::table('regions')
            ->select('flood_status', DB::raw('count(*) as total'))
            ->groupBy('flood_status')
            ->get()
            ->pluck('total', 'flood_status');

        return response()->json([
            'status' => 'success',
            'data' => [
                'regions' => $regions,
                'summary' => [
                    'awas' => $summary['awas'] ?? 0,
                    'siaga' => $summary['siaga'] ?? 0,
                    'normal' => $summary['normal'] ?? 0,
                ]
            ]
        ]);
    }

    /**
     * GET /api/admin/dashboard/report-recap
     * Rekapitulasi laporan berdasarkan periode
     */
    public function reportRecap(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'nullable|in:officer,public,all' // Tipe laporan
        ]);

        $type = $validated['type'] ?? 'all';
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        $data = [];

        // Laporan Petugas
        if ($type === 'officer' || $type === 'all') {
            $officerReports = OfficerReport::with(['officer', 'station'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $officerSummary = [
                'total' => $officerReports->count(),
                'approved' => $officerReports->where('validation_status', 'approved')->count(),
                'rejected' => $officerReports->where('validation_status', 'rejected')->count(),
                'pending' => $officerReports->where('validation_status', 'pending')->count(),
            ];

            $data['officer_reports'] = [
                'summary' => $officerSummary,
                'details' => $officerReports
            ];
        }

        // Laporan Masyarakat
        if ($type === 'public' || $type === 'all') {
            $publicReports = PublicReport::with(['user'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $publicSummary = [
                'total' => $publicReports->count(),
                'pending' => $publicReports->where('status', 'pending')->count(),
                'diproses' => $publicReports->where('status', 'diproses')->count(),
                'selesai' => $publicReports->where('status', 'selesai')->count(),
                'emergency' => $publicReports->where('status', 'emergency')->count(),
            ];

            $data['public_reports'] = [
                'summary' => $publicSummary,
                'details' => $publicReports
            ];
        }

        return response()->json([
            'status' => 'success',
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'data' => $data
        ]);
    }
}
