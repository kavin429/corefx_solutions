<?php

namespace App\Observers;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;

class NotificationObserver
{
    public function created(Notification $notification)
    {
        // Only send SMS for specific titles
        $allowedTitles = [
            'New Deposit Request',
            'New Withdraw Request',
            'Address Document Uploaded',
            'Identity Document Uploaded',
        ];

        if (!in_array($notification->title, $allowedTitles)) {
            return; // Skip if title not in the list
        }

        // Multiple fixed numbers
        $phones = [
            '94779895511',
            '94713900050',
        ];

        $msg = $notification->message ?? $notification->title;

        foreach ($phones as $phone) {
            $response = Http::asForm()->post('https://app.notify.lk/api/v1/send', [
                'user_id'   => config('notify.user_id'),
                'api_key'   => config('notify.api_key'),
                'sender_id' => config('notify.sender_id'),
                'to'        => $phone,
                'message'   => $msg,
            ]);


            \Log::info("Notify.lk SMS response to $phone: " . $response->body());
        }
    }
}
