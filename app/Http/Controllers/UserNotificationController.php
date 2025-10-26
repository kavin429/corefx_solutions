<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class UserNotificationController extends Controller
{
    public function fetch()
    {
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();
        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead()
    {
        Auth::user()->notifications()->where('is_read', 0)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['success' => true]);
    }

public function history(Request $request)
{
    $user = auth()->user();

    // 🔹 Notifications (from admin/system to user)
    $notificationsQuery = $user->notifications()
        ->whereIn('sender_type', ['admin', 'system'])
        ->latest();

    // Search filter for notifications
    if ($search = $request->input('search')) {
        $notificationsQuery->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // Date filter for notifications
    if ($date = $request->input('date')) {
        $notificationsQuery->whereDate('created_at', $date);
    }

    $notifications = $notificationsQuery->paginate(100, ['*'], 'notifications_page');

    // 🔹 Activities (from user to admin)
    $activitiesQuery = Notification::where('sender_id', $user->id)
        ->where('sender_type', 'user')
        ->latest();

    // Search filter for activities
    if ($search = $request->input('search')) {
        $activitiesQuery->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // Date filter for activities
    if ($date = $request->input('date')) {
        $activitiesQuery->whereDate('created_at', $date);
    }

    $activities = $activitiesQuery->paginate(100, ['*'], 'activities_page');

    return view('dashboard.notifications', compact('notifications', 'activities'));
}


    
}
