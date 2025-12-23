<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'water_level',
        'status',
        'threshold_siaga',
        'threshold_awas',
        'last_update'
    ];

    // Relasi ke wilayah yang dipengaruhi oleh stasiun ini [cite: 59]
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class, 'influenced_by_station_id');
    }

    // Relasi ke histori laporan petugas [cite: 63]
    public function officerReports(): HasMany
    {
        return $this->hasMany(OfficerReport::class);
    }

    public function officers()
    {
        // Stasiun memiliki banyak petugas
        return $this->belongsToMany(User::class, 'station_user');
    }
}
