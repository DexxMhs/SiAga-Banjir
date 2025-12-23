<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'name',
        'flood_status',
        'influenced_by_station_id'
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
}
