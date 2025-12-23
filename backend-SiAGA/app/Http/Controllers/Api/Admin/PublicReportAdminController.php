<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicReport;
use App\Http\Requests\Api\Admin\PublicReportUpdateRequest;

class PublicReportAdminController extends Controller
{
    /**
     * GET /api/admin/reports/public
     * Menampilkan semua laporan dari masyarakat
     */
    public function index()
    {
        $reports = PublicReport::with('user')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reports
        ]);
    }

    /**
     * PUT /api/admin/reports/public/{id}
     * Memperbarui status atau menindaklanjuti laporan masyarakat
     */
    public function update(PublicReportUpdateRequest $request, $id)
    {
        $report = PublicReport::findOrFail($id);

        $report->update([
            'status' => $request->status // Akan berisi "Baru", "Diproses", atau "Selesai"
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status laporan masyarakat berhasil diperbarui ke: ' . $request->status,
            'data' => $report
        ]);
    }
}
