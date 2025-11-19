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

    public function uploadBoth(Request $request)
    {
        $request->validate([
            'identity_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'address_document'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        $messages = [];

        // Upload Identity Document
        if ($request->hasFile('identity_document')) {
            $path = $request->file('identity_document')->store('verifications/identity', 'public');
            $status = ($profile->identity_status === 'verified') ? 'verified' : 'pending';
            $profile->update([
                'identity_document_path' => $path,
                'identity_status' => $status,
            ]);

            $messages[] = 'Identity document uploaded successfully.';

            // Notify admins
            $this->notifyAdmins(
                'Identity Document Uploaded',
                "{$user->name} uploaded an identity document for verification."
            );
        }

        // Upload Address Document
        if ($request->hasFile('address_document')) {
            $path = $request->file('address_document')->store('verifications/address', 'public');
            $status = ($profile->address_status === 'verified') ? 'verified' : 'pending';
            $profile->update([
                'address_document_path' => $path,
                'address_status' => $status,
            ]);

            $messages[] = 'Address document uploaded successfully.';

            // Notify admins
            $this->notifyAdmins(
                'Address Document Uploaded',
                "{$user->name} uploaded an address document for verification."
            );
        }

        if (empty($messages)) {
            return back()->with('error', 'Please select at least one document to upload.');
        }

        return back()->with('success', implode(' ', $messages));
    }

    private function notifyAdmins($title, $message)
    {
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => auth()->id(),
                'sender_type'     => 'user',
                'title'           => $title,
                'message'         => $message,
                'is_read'         => 0,
            ]);
        }
    }
}
