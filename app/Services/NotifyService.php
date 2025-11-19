<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotifyService
{
    public function sendSMS($phone, $message)
    {
        $url = "https://app.notify.lk/api/v1/send";

        $response = Http::get($url, [
            'user_id' => env('NOTIFY_USER_ID'),
            'api_key' => env('NOTIFY_API_KEY'),
            'sender_id' => env('NOTIFY_SENDER_ID'),
            'to' => $phone,
            'message' => $message
        ]);

        return $response->json();
    }

    public function smsBalance()
    {
        $url = "https://app.notify.lk/api/v1/get-balance";

        $response = Http::get($url, [
            'user_id' => env('NOTIFY_USER_ID'),
            'api_key' => env('NOTIFY_API_KEY')
        ]);

        return $response->json();
    }
}
