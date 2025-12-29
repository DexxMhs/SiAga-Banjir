<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PublicReportsExport;
use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PublicReportController extends Controller
{
    /**
     * Menampilkan daftar laporan masuk.
     * Biasanya diurutkan dari yang terbaru atau yang statusnya 'emergency'.
     */
    public function index(Request $request)
    {
        // 1. Base Query
        $query = PublicReport::with(['user', 'validator'])->latest();

        $stats = [
            'total_today' => PublicReport::whereDate('created_at', Carbon::today())->count(),
            'pending'     => PublicReport::where('status', 'pending')->count(),
            'emergency'   => PublicReport::where('status', 'emergency')->count(),
        ];

        // 2. Filter Search (Kode Laporan, Lokasi, Nama Pelapor)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%$search%")
                    ->orWhere('location', 'like', "%$search%")
                    ->orWhereHas('user', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%$search%");
                    });
            });
        }

        // 3. Filter Status
        if ($request->filled('status') && $request->status != 'Semua Status') {
            // Mapping label UI ke value database (jika perlu)
            // Sesuaikan key (kiri) dengan value di <option> HTML kamu
            $statusMap = [
                'Menunggu' => 'pending',
                'Diproses' => 'diproses',
                'Selesai'  => 'selesai',
                'Darurat'  => 'emergency'
            ];

            // Cek apakah input ada di map, jika tidak, pakai nilai mentah
            $statusValue = $statusMap[$request->status] ?? $request->status;

            $query->where('status', $statusValue);
        }

        // 4. Filter Date
        if ($request->filled('date')) {
            switch ($request->date) {
                case '24 Jam Terakhir':
                    $query->where('created_at', '>=', Carbon::now()->subDay());
                    break;
                case 'Minggu Ini':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'Bulan Ini':
                    $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // 5. Pagination
        // ->appends($request->all()) penting agar saat klik 'Page 2', filter tidak hilang
        $reports = $query->paginate(10)->appends($request->all());

        return view('admin.pages.public-reports.index', compact('reports', 'stats'));
    }
    /**
     * Menampilkan detail satu laporan.
     */
    public function show($id)
    {
        $report = PublicReport::with(['user', 'validator'])->findOrFail($id);

        return view('admin.pages.public-reports.show', compact('report'));
    }

    /**
     * Fungsi Utama: Validasi Laporan
     * Admin mengubah status dan (opsional) memberikan catatan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'     => 'required|in:pending,diproses,selesai,emergency',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $report = PublicReport::findOrFail($id);

        // Update data
        $report->update([
            'status'       => $request->status,
            'admin_note'   => $request->admin_note,
            // Otomatis mengisi ID admin yang sedang login saat ini
            'validated_by' => Auth::id(),
        ]);

        return redirect()->route('public-reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        // Menggunakan Carbon untuk nama file yang unik dengan timestamp
        $fileName = 'laporan-masyarakat-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new PublicReportsExport($request), $fileName);
    }

    public function print(string $id)
    {
        // Ambil data laporan beserta relasinya
        $report = PublicReport::with(['user', 'validator'])->findOrFail($id);

        // Load view khusus untuk cetak (kita buat di langkah 3)
        $pdf = Pdf::loadView('admin.pages.public-reports.print', compact('report'));

        // Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Stream (tampilkan di browser) atau Download
        // Menggunakan stream agar user bisa melihat preview dulu sebelum print fisik
        return $pdf->stream('Laporan-Masyarakat-' . $report->report_code . '.pdf');
    }
}
