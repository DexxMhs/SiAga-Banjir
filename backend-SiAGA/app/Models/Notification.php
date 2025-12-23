<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'data',
        'read_at',
    ];

    /**
     * Casting atribut agar otomatis terkonversi saat diakses.
     */
    protected $casts = [
        'data' => 'array',      // Mengubah JSON di DB menjadi Array PHP secara otomatis
        'read_at' => 'datetime', // Mengubah string tanggal menjadi objek Carbon/Datetime
    ];

    /**
     * Relasi ke User: Satu notifikasi dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk mengambil notifikasi yang belum dibaca saja.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
