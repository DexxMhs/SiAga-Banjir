<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Region extends Model
{
    use Notifiable;
    protected $fillable = [
        'name',
        'photo',          // Baru
        'location',       // Baru
        'latitude',       // Baru
        'longitude',      // Baru
        'flood_status',
        'risk_note',      // Baru
    ];

    // Setiap wilayah dipengaruhi oleh satu stasiun [cite: 59]
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'influenced_by_station_id');
    }

    // User (Masyarakat) yang terdaftar di wilayah ini
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function relatedStations()
    {
        return $this->belongsToMany(Station::class)
            ->withPivot('impact_percentage', 'travel_time_minutes')
            ->withTimestamps();
    }

    // Helper untuk cek status tertinggi dari semua stasiun terkait
    public function getWorstStatusAttribute()
    {
        $statuses = $this->relatedStations->pluck('status')->toArray();

        if (in_array('awas', $statuses)) return 'awas';
        if (in_array('siaga', $statuses)) return 'siaga';
        return 'normal';
    }

    public function routeNotificationForFcm()
    {
        return null;
    }
}
