<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficerReport extends Model
{
    protected $fillable = [
        'report_code',
        'officer_id',
        'station_id',
        'water_level',
        'rainfall',
        'pump_status',
        'calculated_status',
        'photo',
        'note',
        'validation_status', // pending/approved/rejected
        'validated_by'
    ];

    // Relasi ke petugas yang melapor [cite: 62]
    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    // Relasi ke stasiun yang dilaporkan [cite: 63]
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    // Relasi ke admin yang memvalidasi laporan [cite: 98]
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
