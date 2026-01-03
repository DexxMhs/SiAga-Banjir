<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Models\OfficerReport; // [BARU]
use App\Models\Region;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        // 1. Parameter Filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // 2. Query Dasar
        $publicQuery = PublicReport::with(['user']);
        $officerQuery = OfficerReport::with(['officer', 'station']); // [BARU]

        // 3. Filter Tanggal (Berlaku untuk keduanya)
        if ($startDate && $endDate) {
            $range = [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()];
            $publicQuery->whereBetween('created_at', $range);
            $officerQuery->whereBetween('created_at', $range);
        } else {
            // Default 6 bulan terakhir agar data tidak terlalu berat
            $defaultStart = Carbon::now()->subMonths(6)->startOfMonth();
            $publicQuery->whereDate('created_at', '>=', $defaultStart);
            $officerQuery->whereDate('created_at', '>=', $defaultStart);
        }

        // 4. Filter Search
        if ($search) {
            $publicQuery->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });

            $officerQuery->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%{$search}%")
                    ->orWhereHas('station', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // ==========================================
        // 5. DATA STATISTIK GABUNGAN
        // ==========================================
        // Clone query untuk hitung-hitungan
        $pStats = clone $publicQuery;
        $oStats = clone $officerQuery;

        $stats = [
            'total' => $pStats->count() + $oStats->count(),

            // Emergency (Public) + Awas (Officer Calculation)
            'critical' => (clone $pStats)->where('status', 'emergency')->count() +
                (clone $oStats)->where('calculated_status', 'awas')->count(),

            // Selesai (Public) + Approved (Officer)
            'completed' => (clone $pStats)->where('status', 'selesai')->count() +
                (clone $oStats)->where('validation_status', 'approved')->count(),
        ];

        // ==========================================
        // 6. DATA GRAFIK (TREN BULANAN)
        // ==========================================
        // Kita butuh range 6 bulan untuk grafik (atau sesuai filter)
        $chartEndDate = $endDate ? Carbon::parse($endDate) : Carbon::now();
        $chartStartDate = $chartEndDate->copy()->subMonths(5)->startOfMonth(); // 6 bulan view

        // Helper function untuk group by month
        $getMonthlyData = function ($queryModel) use ($chartStartDate, $chartEndDate) {
            return $queryModel
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                ->whereBetween('created_at', [$chartStartDate, $chartEndDate->endOfDay()])
                ->groupBy('year', 'month')
                ->get();
        };

        $rawPublicTrend = $getMonthlyData(clone $publicQuery);
        $rawOfficerTrend = $getMonthlyData(clone $officerQuery);

        $chartLabels = [];
        $publicTrendData = [];
        $officerTrendData = [];

        $period = CarbonPeriod::create($chartStartDate, '1 month', $chartEndDate);

        foreach ($period as $date) {
            $chartLabels[] = $date->translatedFormat('M Y');

            // Match data Public
            $pFound = $rawPublicTrend->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });
            $publicTrendData[] = $pFound ? $pFound->total : 0;

            // Match data Officer
            $oFound = $rawOfficerTrend->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });
            $officerTrendData[] = $oFound ? $oFound->total : 0;
        }

        // ==========================================
        // 7. DATA STATUS CHART (DONUT)
        // ==========================================
        // Kita gabungkan status validasi
        $chartStatusData = [
            'approved' => $stats['completed'], // Selesai + Approved
            'pending'  => (clone $pStats)->where('status', 'pending')->count() + (clone $oStats)->where('validation_status', 'pending')->count(),
            'rejected' => (clone $oStats)->where('validation_status', 'rejected')->count(), // Public report jarang ada rejected explicit, biasanya dihapus/spam
            'emergency' => (clone $pStats)->where('status', 'emergency')->count() // Khusus Public
        ];

        // ==========================================
        // 8. DATA TABEL
        // ==========================================
        // Kita kirim dua variabel terpisah agar bisa dibuat Tab di view
        $publicReports = $publicQuery->latest()->paginate(5, ['*'], 'public_page')->withQueryString();
        $officerReports = $officerQuery->latest()->paginate(5, ['*'], 'officer_page')->withQueryString();

        return view('admin.pages.recap.index', compact(
            'publicReports',
            'officerReports',
            'stats',
            'chartLabels',
            'publicTrendData',
            'officerTrendData',
            'chartStatusData'
        ));
    }

    public function print(Request $request)
    {
        // 1. Ambil Parameter Filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // 2. Query Dasar
        $publicQuery = PublicReport::with(['user']);
        $officerQuery = OfficerReport::with(['officer', 'station']);

        // 3. Terapkan Filter (Sama persis dengan index)
        if ($startDate && $endDate) {
            $range = [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()];
            $publicQuery->whereBetween('created_at', $range);
            $officerQuery->whereBetween('created_at', $range);
        } else {
            // Default 1 bulan terakhir untuk cetak agar tidak terlalu berat
            $defaultStart = Carbon::now()->subMonths(1)->startOfMonth();
            $publicQuery->whereDate('created_at', '>=', $defaultStart);
            $officerQuery->whereDate('created_at', '>=', $defaultStart);
        }

        if ($search) {
            $publicQuery->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
            $officerQuery->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%{$search}%")
                    ->orWhereHas('station', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 4. Ambil Data (GET ALL - Tanpa Pagination untuk PDF)
        $publicReports = $publicQuery->latest()->get();
        $officerReports = $officerQuery->latest()->get();

        // 5. Generate PDF
        $pdf = Pdf::loadView('admin.pages.recap.print', compact(
            'publicReports',
            'officerReports',
            'startDate',
            'endDate'
        ));

        // Set ukuran kertas (A4 Landscape agar muat tabel lebar)
        $pdf->setPaper('a4', 'landscape');

        // Download atau Stream (Tampil di browser)
        return $pdf->stream('laporan-banjir-' . now()->format('Y-m-d') . '.pdf');
    }
}
