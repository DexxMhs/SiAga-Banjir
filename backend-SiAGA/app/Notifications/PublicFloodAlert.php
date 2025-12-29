<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\Resources\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class PublicFloodAlert extends Notification
{
    use Queueable;

    protected $status;
    protected $regionName;

    public function __construct($status, $regionName)
    {
        $this->status = $status;
        $this->regionName = $regionName;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class]; // Hanya ke FCM (HP), tidak perlu simpan di DB admin
    }

    public function toFcm($notifiable)
    {
        // $notifiable di sini adalah object Region
        // Kita set target TOPIC-nya sesuai ID region
        $topicName = 'region_' . $notifiable->id;

        // Tentukan warna/isi pesan berdasarkan status
        $title = "PERINGATAN BANJIR! 📢";
        $body = "Wilayah {$this->regionName} kini berstatus {$this->status}. Harap waspada!";

        if ($this->status == 'awas') {
            $title = "BAHAYA - SIAGA 1 (AWAS) 🚨";
            $body = "Wilayah {$this->regionName} dalam kondisi KRITIS. Segera evakuasi!";
        }

        return FcmMessage::create()
            ->setTopic($topicName) // <--- INI KUNCINYA (Kirim ke Topic)
            ->setNotification(
                FcmNotificationResource::create()
                    ->setTitle($title)
                    ->setBody($body)
            )
            ->setData([
                'screen' => 'alert_detail',
                'region_id' => (string) $notifiable->id,
                'status' => $this->status
            ]);
    }
}
