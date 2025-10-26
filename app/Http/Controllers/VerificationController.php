<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Admin;
use App\Models\Notification;

class VerificationController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;
        return view('dashboard.verification', compact('profile'));
    }

    public function uploadIdentity(Request $request)
    {
        $request->validate([
            'identity_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('identity_document')->store('verifications/identity', 'public');

        $profile = auth()->user()->profile;

        // Only set status to pending if it’s not already verified
        $status = ($profile->identity_status === 'verified') ? 'verified' : 'pending';

        $profile->update([
            'identity_document_path' => $path,
            'identity_status' => $status,
        ]);

        // Send notification to all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => auth()->id(),
                'sender_type'     => 'user',
                'title'           => 'Identity Document Uploaded',
                'message'         => auth()->user()->email . " uploaded an identity document for verification.",
                'is_read'         => 0,
            ]);
        }

        return back()->with('success', 'Identity document uploaded successfully.');
    }

    public function uploadAddress(Request $request)
    {
        $request->validate([
            'address_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('address_document')->store('verifications/address', 'public');

        $profile = auth()->user()->profile;

        // Only set status to pending if it’s not already verified
        $status = ($profile->address_status === 'verified') ? 'verified' : 'pending';

        $profile->update([
            'address_document_path' => $path,
            'address_status' => $status,
        ]);

        // Send notification to all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => auth()->id(),
                'sender_type'     => 'user',
                'title'           => 'Address Document Uploaded',
                'message'         => auth()->user()->email . " uploaded an address document for verification.",
                'is_read'         => 0,
            ]);
        }

        return back()->with('success', 'Address document uploaded successfully.');
    }
}
