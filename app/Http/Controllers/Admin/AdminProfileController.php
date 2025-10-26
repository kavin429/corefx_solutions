<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{

    // Show the admin profile edit page

    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.adminProfile', compact('admin'));
    }

    // Update admin profile (name, email, profile picture)

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Validation
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'email');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($admin->profile_picture && Storage::disk('public')->exists($admin->profile_picture)) {
                Storage::disk('public')->delete($admin->profile_picture);
            }

            $data['profile_picture'] = $request->file('profile_picture')->store('admins', 'public');
        }

        // Update admin
        $admin->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    // Update admin password

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
