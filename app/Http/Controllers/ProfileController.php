<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Notification;

class ProfileController extends Controller
{
    // Show the user's profile.
    public function show()
    {
        $user = Auth::user(); // Get authenticated user
        return view('dashboard.profile', compact('user'));
    }

    // Update user's avatar.
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'],
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        // Delete old avatar if exists
        if ($profile->avatar_path && Storage::disk('public')->exists($profile->avatar_path)) {
            Storage::disk('public')->delete($profile->avatar_path);
        }

        // Store new avatar in storage/app/public/avatars
        $path = $request->file('avatar')->store('avatars', 'public');

        // Update profile with path
        $profile->update([
            'avatar_path' => $path,
        ]);

        // ✅ Notify all admins about avatar update
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'Profile Picture Updated',
                'message'         => Auth::user()->email . ' (User ID: ' . Auth::id() . ') updated their profile picture.',
                'is_read'         => 0,
            ]);
        }

        return back()->with('success', 'Profile picture updated successfully.');
    }

    // Change user's password.
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        // Check current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Your current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => \Hash::make($request->new_password),
        ]);

        // ✅ Notify all admins about password change
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Notification::create([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => Auth::id(),
                'sender_type'     => 'user',
                'title'           => 'Password Changed',
                'message'         => Auth::user()->email . ' (User ID: ' . Auth::id() . ') changed their account password.',
                'is_read'         => 0,
            ]);
        }

        return back()->with('success', 'Password updated successfully.');
    }
}
