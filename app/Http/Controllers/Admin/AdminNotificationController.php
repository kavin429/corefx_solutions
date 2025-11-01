<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class AdminNotificationController extends Controller
{

    // Display notification history with optional filters.
    public function index(Request $request)
    {
        $users = User::all();

        $notificationsQuery = Notification::latest();

        // Filter by date
        if ($request->start_date && $request->end_date) {
            $notificationsQuery->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter by sender type (admin or user)
        if ($request->sender_type) {
            $notificationsQuery->where('sender_type', $request->sender_type);
        }

        // Filter by recipient type (user or admin)
        if ($request->recipient_type) {
            $notificationsQuery->where(
                'notifiable_type',
                $request->recipient_type === 'user' ? 'App\Models\User' : 'App\Models\Admin'
            );
        }

        // 🔹 Search filter (title, message, or sender_id)
if ($request->filled('search')) {
    $notificationsQuery->where(function ($q) use ($request) {
        $q->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('message', 'like', '%' . $request->search . '%')
          ->orWhere('sender_id', $request->search); // exact match for sender_id
    });
}


        $notifications = $notificationsQuery->paginate(100)->withQueryString();

        // 🔹 Apply same search & date filters to admin activities too
        $activitiesQuery = Notification::where('sender_type', 'admin')->latest();

        if ($request->start_date && $request->end_date) {
            $activitiesQuery->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('search')) {
            $activitiesQuery->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        $activities = $activitiesQuery->paginate(100, ['*'], 'activities_page')->withQueryString();

        return view('admin.send_notification', compact('users', 'notifications', 'activities'));
    }


    // Show the send notification form.
    public function create()
    {
        $users = User::all();

        // 🔹 Separate admin activities (sent by admin)
        $activities = Notification::where('sender_type', 'admin')
            ->orderByDesc('created_at')
            ->paginate(100, ['*'], 'activities_page');

        // 🔹 Separate received notifications (from users or system)
        $notifications = Notification::whereIn('sender_type', ['user', 'system'])
            ->orderByDesc('created_at')
            ->paginate(100, ['*'], 'notifications_page');

        return view('admin.send_notification', compact('users', 'notifications', 'activities'));
    }


    // Handle sending notifications to selected users.
    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'users' => 'required|array',
        ]);

        $title = $request->title;
        $message = $request->message;
        $selectedUsers = $request->users;

        // If 'all' selected, send to all users
        if (in_array('all', $selectedUsers)) {
            $users = User::all();
        } else {
            $users = User::whereIn('id', $selectedUsers)->get();
        }

        foreach ($users as $user) {
            Notification::create([
                'notifiable_id' => $user->id,
                'notifiable_type' => 'App\Models\User',
                'sender_id' => auth()->guard('admin')->id(),
                'sender_type' => 'admin',
                'title' => $title,
                'message' => $message,
                'is_read' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Notification sent successfully!');
    }

public function bulkDeleteActivities(Request $request)
{
    $ids = $request->input('selected', []);
    if (!empty($ids)) {
        // Delete only admin activities (notifications sent by admin)
        Notification::whereIn('id', $ids)
            ->where('sender_type', 'admin')
            ->delete();

        return back()->with('success', 'Selected activities deleted successfully.');
    }
    return back()->with('error', 'No activities selected.');
}

public function bulkDeleteNotifications(Request $request)
{
    $ids = $request->input('selected', []);
    if (!empty($ids)) {
        Notification::whereIn('id', $ids)->delete();
        return back()->with('success', 'Selected notifications deleted successfully.');
    }
    return back()->with('error', 'No notifications selected.');
}


    
}
