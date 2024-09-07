<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    public function sendOrderNotification($data)
    {
        Http::post('http://nodejs-server-url:port/send-notification', $data);
    }
}