<?php

namespace App\Exports;

use App\Models\PublicReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicReportsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        // 1. Base Query: Load relasi user (pelapor) dan validator (admin)
        $query = PublicReport::with(['user', 'validator'])->latest();

        // 2. Filter Search
        // Mencari berdasarkan: Kode Laporan, Lokasi, atau Nama Pelapor
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%$search%")
                    ->orWhere('location', 'like', "%$search%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        // 3. Filter Status
        // Menggunakan mapping jika input dari frontend berupa Bahasa Indonesia
        // atau langsung jika inputnya raw value.
        if ($this->request->filled('status') && $this->request->status != 'Semua Status') {

            // Opsional: Mapping jika UI mengirim "Menunggu" alih-alih "pending"
            $statusMap = [
                'Menunggu' => 'pending',
                'Diproses' => 'diproses',
                'Selesai'  => 'selesai',
                'Darurat'  => 'emergency'
            ];

            // Cek apakah input ada di map, jika tidak pakai nilai aslinya
            $statusValue = $statusMap[$this->request->status] ?? $this->request->status;

            $query->where('status', $statusValue);
        }

        // 4. Filter Date (Logic sama persis dengan contohmu)
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
            $report->report_code,                   // Kode Laporan
            $report->created_at->format('d-m-Y H:i'), // Waktu Lapor
            $report->user->name ?? 'User Terhapus', // Nama Pelapor
            $report->location,                      // Lokasi
            $report->water_level . ' cm',           // Tinggi Air
            ucfirst($report->status),               // Status (Pending/Selesai/dll)
            $report->validator->name ?? '-',        // Admin Validator
            $report->admin_note ?? '-',             // Catatan Admin
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Laporan',
            'Waktu Lapor',
            'Nama Pelapor',
            'Lokasi Kejadian',
            'Tinggi Air',
            'Status Laporan',
            'Divalidasi Oleh',
            'Catatan Admin',
        ];
    }
}
