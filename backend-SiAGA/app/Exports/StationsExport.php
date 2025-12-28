<?php

namespace App\Exports;

use App\Models\Station;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $status;

    // 1. Terima parameter dari Controller lewat Constructor
    public function __construct($search = null, $status = null)
    {
        $this->search = $search;
        $this->status = $status;
    }

    /**
     * 2. Filter query sebelum di-export
     */
    public function collection()
    {
        return Station::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('location', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->get(); // Gunakan get(), jangan paginate() untuk export
    }

    /**
     * 1. Tambahkan Header (Baris Pertama)
     */
    public function headings(): array
    {
        return [
            'ID POS',
            'NAMA POS PANTAU',
            'LOKASI TERPASANG',
            'KOORDINAT (LAT, LONG)',
            'TINGGI AIR (CM)',
            'STATUS SAAT INI',
            'WAKTU UPDATE TERAKHIR',
        ];
    }

    /**
     * 2. Map data agar rapi (Sesuai kolom header)
     */
    public function map($station): array
    {
        return [
            $station->id,
            $station->name,
            $station->location,
            $station->latitude . ', ' . $station->longitude,
            $station->water_level,
            strtoupper($station->status),
            $station->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * 3. Styling Header (Membuat Baris 1 jadi Bold & Berwarna)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style baris nomor 1 (Header)
            1    => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'] // Warna Biru
                ],
            ],
        ];
    }
}
