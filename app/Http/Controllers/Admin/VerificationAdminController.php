<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Notification;

class VerificationAdminController extends Controller
{
    // Show all verification requests with search functionality
    public function index(Request $request)
    {
        $query = UserProfile::with('user')->orderBy('created_at', 'desc');

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $profiles = $query->paginate(100); // 100 records per page

        return view('admin.adminVerifications', compact('profiles'));
    }

    // Identity approval/rejection
    public function approveIdentity(UserProfile $profile)
    {
        $profile->update(['identity_status' => 'verified']);

        // Send notification to user
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Identity Verified',
            'message' => 'Your identity document has been approved by the Infinity Trade Solutions LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Identity document approved and user notified.');
    }

    public function rejectIdentity(UserProfile $profile)
    {
        $profile->update(['identity_status' => 'rejected']);

        // Send notification to user
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Identity Rejected',
            'message' => 'Your identity document has been rejected by the Infinity Trade Solutions LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Identity document rejected and user notified.');
    }

    // Address approval/rejection
    public function approveAddress(UserProfile $profile)
    {
        $profile->update(['address_status' => 'verified']);

        // Send notification to user
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Address Verified',
            'message' => 'Your address document has been approved by the Infinity Trade Solutions LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Address document approved and user notified.');
    }

    public function rejectAddress(UserProfile $profile)
    {
        $profile->update(['address_status' => 'rejected']);

        // Send notification to user
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Address Rejected',
            'message' => 'Your address document has been rejected by the Infinity Trade Solutions LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Address document rejected and user notified.');
    }
}
