<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Fetch latest notifications
    public function fetch()
    {
        $adminId = auth()->guard('admin')->id();

        $notifications = Notification::where('notifiable_id', $adminId)
            ->where('notifiable_type', 'App\Models\Admin')
            ->latest()
            ->take(20)
            ->get();

        return response()->json(['notifications' => $notifications]);
    }

    // Mark all notifications as read
    public function markAsRead()
    {
        $adminId = auth()->guard('admin')->id();

        Notification::where('notifiable_id', $adminId)
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}
