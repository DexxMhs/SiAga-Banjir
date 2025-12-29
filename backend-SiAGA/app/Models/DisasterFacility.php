<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DisasterFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code',
        'name',
        'type',
        'status',
        'address',
        'latitude',
        'longitude',
        'photo_path',
        'notes',
    ];

    // Kolom tambahan yang akan muncul di JSON
    protected $appends = ['photo_url'];

    protected static function booted()
    {
        static::creating(function ($facility) {
            // Jika unique_code belum diisi manual, kita generate otomatis
            if (empty($facility->unique_code)) {
                $facility->unique_code = self::generateUniqueCode($facility->type);
            }
        });
    }

    /**
     * Logic Pemformatan Kode Unik
     * Format: [PREFIX]-[TAHUN]-[RANDOM 4 HURUF/ANGKA]
     * Contoh: PNG-2025-A1B2
     */
    public static function generateUniqueCode($type)
    {
        // 1. Tentukan Prefix berdasarkan Tipe Fasilitas
        $prefix = match ($type) {
            'pengungsian' => 'PNG', // PeNGungsian
            'dapur_umum' => 'DPR',  // DaPuR
            'posko_kesehatan' => 'MED', // MEDis
            'logistik' => 'LOG',    // LOGistik
            default => 'FAC',       // FACility (Default)
        };

        // 2. Ambil Tahun Sekarang
        $year = date('Y');

        // 3. Generate sampai menemukan kode yang belum terpakai (Unik)
        do {
            // Random string 4 karakter kapital (angka/huruf)
            $random = strtoupper(Str::random(4));

            // Gabungkan formatnya
            $code = "{$prefix}-{$year}-{$random}";

            // Cek database, ulangi jika kebetulan ada yang sama
        } while (self::where('unique_code', $code)->exists());

        return $code;
    }


    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return url(Storage::url($this->photo_path));
        }
        // Gambar default jika tidak ada foto
        return 'https://via.placeholder.com/640x480.png?text=No+Image';
    }
}
