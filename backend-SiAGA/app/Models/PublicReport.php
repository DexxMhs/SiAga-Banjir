<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicReport extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'photo',
        'water_height',
        'status'
    ];

    // Relasi ke user masyarakat yang melapor [cite: 72]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
