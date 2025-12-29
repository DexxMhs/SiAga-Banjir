<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_code',
        'user_id',
        'location',
        'latitude',
        'longitude',
        'water_level',
        'photo',
        'note',
        'admin_note',
        'status',
        'validated_by',
    ];

    // Relasi ke user masyarakat yang melapor [cite: 72]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // (Opsional) Accessor untuk mendapatkan URL foto lengkap jika menggunakan Storage
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
