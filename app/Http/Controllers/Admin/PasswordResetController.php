<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    // Show all password reset requests
    public function index()
    {
        $users = User::where('password_reset_requested', true)->get();
        return view('admin.password_requests.index', compact('users'));
    }

    // Manually reset password and send email
    public function send(User $user)
    {
        try {
            // Generate random password
            $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

            // Save hashed password
            $user->password = bcrypt($newPassword);
            $user->save();

            // Send email
            Mail::raw(
                "Hello {$user->name},\n\n".
                "We have reset your password for your account at CoreFX Solutions.\n\n".
                "Your new login credentials are:\n".
                "-----------------------------------\n".
                "Email: {$user->email}\n".
                "Password: {$newPassword}\n".
                "-----------------------------------\n\n".
                "For security reasons, we recommend that you log in immediately and change your password.\n\n".
                "Thank you for being a valued member of CoreFX Solutions.\n".
                "— The CoreFX Solutions Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('CoreFX Solutions - Password Reset Notification');
                }
            );

            return redirect()->back()->with('success', "Password reset successfully and sent to {$user->email}.");
        }   
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
        }
    }   

}
