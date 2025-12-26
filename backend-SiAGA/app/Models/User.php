<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi (Mass Assignment).
     * Sesuai dengan spesifikasi: id, name, username, password, role, region_id, notification_token[cite: 45, 72].
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',                // admin, petugas, public
        'region_id',           // Relasi ke tabel regions [cite: 55]
        'notification_token',  // Untuk push notification [cite: 44]
        'photo',               // Foto profil user
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi JSON (untuk keamanan API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast kolom ke tipe data tertentu.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Wilayah (Hanya untuk Role: Public).
     * Setiap user public terhubung ke satu wilayah berpotensi banjir[cite: 55, 72].
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Relasi ke Laporan Petugas (Hanya untuk Role: Petugas).
     * Seorang petugas bisa mengirim banyak laporan kondisi pintu air[cite: 60, 62].
     */
    public function officerReports(): HasMany
    {
        return $this->hasMany(OfficerReport::class, 'officer_id');
    }

    /**
     * Relasi ke Laporan Masyarakat (Hanya untuk Role: Public).
     * User public dapat mengirimkan banyak laporan kejadian banjir[cite: 70, 72].
     */
    public function publicReports(): HasMany
    {
        return $this->hasMany(PublicReport::class);
    }

    /**
     * Relasi ke Notifications: Satu user bisa memiliki banyak notifikasi.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function assignedStations()
    {
        // Petugas memiliki banyak stasiun yang ditugaskan
        return $this->belongsToMany(Station::class, 'station_user');
    }
}
