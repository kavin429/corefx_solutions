<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Notification;

class VerificationAdminController extends Controller
{
    /**
     * Show all verification requests with search functionality
     */
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

    /**
     * Approve identity document
     */
    public function approveIdentity(UserProfile $profile)
    {
        // ✅ Update status and verified timestamp
        $profile->update([
            'identity_status' => 'verified',
            'identity_verified_at' => now(),
        ]);

        // Send notification
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Identity Verified',
            'message' => 'Your identity document has been approved by Trinity Global Capital LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Identity document approved and user notified.');
    }

    /**
     * Reject identity document
     */
    public function rejectIdentity(UserProfile $profile)
    {
        // Update status to rejected
        $profile->update(['identity_status' => 'rejected']);

        // Send notification
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Identity Rejected',
            'message' => 'Your identity document has been rejected by Trinity Global Capital LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Identity document rejected and user notified.');
    }

    /**
     * Approve address document
     */
    public function approveAddress(UserProfile $profile)
    {
        // ✅ Update status and verified timestamp
        $profile->update([
            'address_status' => 'verified',
            'address_verified_at' => now(),
        ]);

        // Send notification
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Address Verified',
            'message' => 'Your address document has been approved by Trinity Global Capital LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Address document approved and user notified.');
    }

    /**
     * Reject address document
     */
    public function rejectAddress(UserProfile $profile)
    {
        // Update status to rejected
        $profile->update(['address_status' => 'rejected']);

        // Send notification
        Notification::create([
            'notifiable_id' => $profile->user_id,
            'notifiable_type' => 'App\Models\User',
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'title' => 'Address Rejected',
            'message' => 'Your address document has been rejected by Trinity Global Capital LTD.',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Address document rejected and user notified.');
    }
}
