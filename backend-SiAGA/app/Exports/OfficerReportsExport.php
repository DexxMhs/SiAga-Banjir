<?php

namespace App\Exports;

use App\Models\OfficerReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfficerReportsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        // 1. Gunakan Query yang SAMA PERSIS dengan Controller Index
        $query = OfficerReport::with(['officer', 'station'])->latest();

        // Filter Search
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhereHas('officer', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('station', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        // Filter Status
        if ($this->request->filled('status') && $this->request->status != 'Semua Status') {
            $statusMap = ['Terverifikasi' => 'approved', 'Menunggu' => 'pending', 'Ditolak' => 'rejected'];
            if (isset($statusMap[$this->request->status])) {
                $query->where('validation_status', $statusMap[$this->request->status]);
            }
        }

        // Filter Date
        if ($this->request->filled('date')) {
            switch ($this->request->date) {
                case '24 Jam Terakhir':
                    $query->where('created_at', '>=', Carbon::now()->subDay());
                    break;
                case 'Minggu Ini':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'Bulan Ini':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
            }
        }

        return $query;
    }

    public function map($report): array
    {
        return [
            $report->created_at->format('d-m-Y H:i'), // Waktu
            $report->officer->name ?? 'Unknown',      // Petugas
            $report->station->name ?? 'Unknown',      // Lokasi
            $report->water_level . ' cm',             // Tinggi Air
            ucfirst($report->calculated_status),      // Status Banjir (Siaga/Awas)
            ucfirst($report->validation_status),      // Status Validasi
        ];
    }

    public function headings(): array
    {
        return [
            'Waktu Lapor',
            'Nama Petugas',
            'Lokasi Pos Pantau',
            'Tinggi Air',
            'Status Keadaan',
            'Status Validasi',
        ];
    }
}
