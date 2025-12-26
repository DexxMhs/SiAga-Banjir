<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Models\Station;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /api/public/dashboard
     * Menampilkan informasi untuk dashboard user/masyarakat
     */
    public function index()
    {
        $user = auth()->user();
        
        // Ambil informasi wilayah user
        $regionInfo = null;
        if ($user->region_id) {
            $region = Region::with('station')->find($user->region_id);
            if ($region && $region->station) {
                $regionInfo = [
                    'region_name' => $region->name,
                    'flood_status' => $region->flood_status,
                    'station_name' => $region->station->name,
                    'water_level' => $region->station->water_level,
                    'status' => $region->station->status,
                    'last_update' => $region->station->last_update,
                ];
            }
        }
        
        // Hitung laporan user
        $totalReports = PublicReport::where('user_id', $user->id)->count();
        $pendingReports = PublicReport::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        // Laporan terbaru user (5 terakhir)
        $myReports = PublicReport::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Daftar semua stasiun dengan status terkini
        $allStations = Station::select('id', 'name', 'location', 'latitude', 'longitude', 'water_level', 'status', 'last_update')
            ->latest('last_update')
            ->get();
        
        // Ringkasan status stasiun
        $stationSummary = Station::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return response()->json([
            'status' => 'success',
            'data' => [
                'user_region' => $regionInfo,
                'summary' => [
                    'total_reports' => $totalReports,
                    'pending_reports' => $pendingReports,
                    'stations_normal' => $stationSummary['normal'] ?? 0,
                    'stations_siaga' => $stationSummary['siaga'] ?? 0,
                    'stations_awas' => $stationSummary['awas'] ?? 0,
                ],
                'my_recent_reports' => $myReports,
                'all_stations' => $allStations,
            ]
        ]);
    }

    /**
     * GET /api/public/reports/history
     * Menampilkan riwayat laporan user
     */
    public function reportHistory(Request $request)
    {
        $query = PublicReport::where('user_id', auth()->id());

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $reports
        ]);
    }

    /**
     * GET /api/public/reports/{id}
     * Detail laporan user
     */
    public function reportDetail($id)
    {
        $report = PublicReport::where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $report
        ]);
    }

    /**
     * GET /api/public/notifications
     * Daftar notifikasi user
     */
    public function notifications(Request $request)
    {
        $query = auth()->user()->notifications();

        // Filter berdasarkan status baca
        if ($request->has('read')) {
            if ($request->read == 'true') {
                $query->whereNotNull('read_at');
            } else {
                $query->whereNull('read_at');
            }
        }

        $notifications = $query->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

    /**
     * PUT /api/public/notifications/{id}/read
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        
        $notification->update(['read_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * POST /api/public/notifications/read-all
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        auth()->user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }
}
