<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService
{
    public function sendNotification($tokens, $title, $body, $data = [])
    {
        $messaging = app('firebase.messaging');

        // Bungkus judul dan isi pesan
        $notification = Notification::create($title, $body);

        // Jika token hanya satu (string), ubah jadi array
        $targetTokens = is_array($tokens) ? $tokens : [$tokens];

        if (count($targetTokens) > 0) {
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data); // Data tambahan (misal ID stasiun)

            // Kirim ke banyak token sekaligus
            $messaging->sendMulticast($message, $targetTokens);
        }
    }
}
