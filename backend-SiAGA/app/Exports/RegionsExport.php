<?php

namespace App\Exports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegionsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $status;

    public function __construct($search, $status)
    {
        $this->search = $search;
        $this->status = $status;
    }

    public function query()
    {
        // Query harus sama persis dengan logic di Controller index
        return Region::query()
            ->with(['relatedStations']) // Load relasi pos pantau
            ->withCount('users')        // Hitung jumlah warga
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%");
            })
            ->when($this->status, function ($query) {
                $query->where('flood_status', $this->status);
            })
            ->latest();
    }

    /**
     * Mengatur data apa saja yang masuk ke kolom Excel
     */
    public function map($region): array
    {
        // Menggabungkan nama-nama pos pantau menjadi satu string (contoh: "Pos Katulampa, Pos Depok")
        $relatedStations = $region->relatedStations->pluck('name')->join(', ');

        return [
            $region->name,
            $region->location ?? '-',
            $region->latitude . ', ' . $region->longitude,
            strtoupper($region->flood_status), // Normal / Siaga / Awas
            $region->risk_note ?? '-',
            $relatedStations ?: 'Tidak ada pos terkait',
            $region->users_count . ' Orang', // Jumlah populasi
            $region->updated_at->format('d-m-Y H:i'),
        ];
    }

    /**
     * Judul Header Kolom
     */
    public function headings(): array
    {
        return [
            'Nama Wilayah',
            'Lokasi Rinci',
            'Koordinat (Lat, Long)',
            'Status Banjir',
            'Catatan Risiko',
            'Pos Pantau Terkait',
            'Jumlah Warga Terdaftar',
            'Terakhir Diupdate',
        ];
    }

    /**
     * Styling Header (Bold)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
