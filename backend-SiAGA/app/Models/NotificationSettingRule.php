<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSettingRule extends Model
{
    use HasFactory;

    // Nama tabel didefinisikan secara eksplisit jika tidak mengikuti jamak bahasa Inggris
    protected $table = 'notification_setting_rules';

    protected $fillable = [
        'status_type',      // Contoh: 'siaga' atau 'awas'
        'message_template', // Contoh: "Peringatan! Pos [station] sekarang berstatus [status]. Harap waspada!"
    ];

    /**
     * Fungsi Helper untuk memformat pesan secara dinamis
     * Mengganti [station] dan [status] dengan data asli
     */
    public function formatMessage($stationName, $status)
    {
        $message = str_replace('[station]', $stationName, $this->message_template);
        $message = str_replace('[status]', strtoupper($status), $message);

        return $message;
    }
}
