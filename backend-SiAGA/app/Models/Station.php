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

    public function impactedRegions()
    {
        return $this->belongsToMany(Region::class)
            ->withPivot('impact_percentage', 'travel_time_minutes')
            ->withTimestamps();
    }
}
