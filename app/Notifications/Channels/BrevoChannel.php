<?php

namespace App\Notifications\Channels;

use App\Notifications\StandardNotification;

class BrevoChannel
{
    public function send($notifiable, StandardNotification $notification)
    {
        if (method_exists($notification, 'toBrevo')) {
            $notification->toBrevo($notifiable);
        }
    }
}
