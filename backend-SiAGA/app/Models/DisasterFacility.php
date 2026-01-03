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

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return url(Storage::url($this->photo_path));
        }
        // Gambar default jika tidak ada foto
        return 'https://via.placeholder.com/640x480.png?text=No+Image';
    }
}
