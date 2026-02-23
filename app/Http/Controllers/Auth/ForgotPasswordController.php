<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle reset request (direct reset + email + notify)
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;

        // -------------------------------
        // Check if user has requested recently (5-minute cooldown)
        // -------------------------------
        if (Cache::has('password_reset_'.$email)) {
            $secondsLeft = Cache::get('password_reset_'.$email) - time();
            return back()->withErrors([
                'email' => "You can request a new password in {$secondsLeft} seconds."
            ]);
        }

        $user = User::where('email', $email)->first();

        // Generate secure random password (10 chars with letters, numbers, symbols)
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
        $newPassword = substr(str_shuffle($characters), 0, 10);

        // Save hashed password
        $user->password = bcrypt($newPassword);
        $user->save();

        // Send email with new password to user
        Mail::raw(
            "Hello {$user->name},\n\n".
            "We have reset your password for your Trinity Global Capital LTD account.\n\n".
            "Your new login credentials are:\n".
            "-----------------------------------\n".
            "Email: {$user->email}\n".
            "Password: {$newPassword}\n".
            "-----------------------------------\n\n".
            "⚠️ For your security, please log in immediately and change this password.\n\n".
            "Thank you,\nThe Trinity Global Capital LTD Team",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Trinity Global Capital LTD - Password Reset Notification');
            }
        );

        // Store notification in DB for the user
        DB::table('notifications')->insert([
            'notifiable_id'   => $user->id,
            'notifiable_type' => User::class,
            'title'           => 'Password Reset Successful',
            'message'         => 'A new password was generated and sent to your email.',
            'is_read'         => 0,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Notify all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            DB::table('notifications')->insert([
                'notifiable_id'   => $admin->id,
                'notifiable_type' => Admin::class,
                'sender_id'       => $user->id,
                'sender_type'     => User::class,
                'title'           => 'User Password Reset',
                'message'         => "User {$user->email} has reset their password.",
                'is_read'         => 0,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // -------------------------------
        // Store 5-minute cooldown in cache
        // -------------------------------
        Cache::put('password_reset_'.$email, time() + 300, 300); // 300 seconds = 5 minutes

        return back()->with('status', 'A new password has been sent to your email. You cannot request another one for 5 minutes.');
    }
}
