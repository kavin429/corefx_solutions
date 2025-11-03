<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyRegistrationMail;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    /**
     * Show OTP verification page.
     */
    public function showVerify(Request $request)
    {
        $email = $request->query('email');
        abort_unless($email, 404);

        $pending = PendingRegistration::where('email', $email)->firstOrFail();
        $remaining = max(0, now()->diffInSeconds($pending->otp_expires_at, false));

        return view('auth.verify-otp', compact('email', 'remaining'));
    }

    /**
     * Verify OTP and create user account.
     */
    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'code'  => ['required','digits:6'],
        ]);

        $pending = PendingRegistration::where('email', $data['email'])->first();

        if (! $pending) {
            throw ValidationException::withMessages([
                'email' => 'This verification session not found. Please sign up again.'
            ]);
        }

        if (now()->greaterThan($pending->otp_expires_at)) {
            $pending->delete();
            throw ValidationException::withMessages([
                'code' => 'Code expired. Please sign up again.'
            ]);
        }

        if ($pending->otp_attempts >= 5) {
            $pending->delete();
            throw ValidationException::withMessages([
                'code' => 'Too many attempts. Please sign up again.'
            ]);
        }

        $pending->increment('otp_attempts');

        if (! Hash::check($data['code'], $pending->otp_hash)) {
            throw ValidationException::withMessages([
                'code' => 'Invalid code.'
            ]);
        }

        // ✅ Check if user already exists
        if (User::where('email', $pending->email)->exists()) {
            $pending->delete();
            throw ValidationException::withMessages([
                'email' => 'An account with this email already exists. Please login instead.'
            ]);
        }

        // ✅ Create user and profile in a transaction
        DB::transaction(function() use ($pending) {

            // Create user
            $user = User::create([
                'first_name'         => $pending->first_name,
                'last_name'          => $pending->last_name,
                'name'               => $pending->first_name . ' ' . $pending->last_name,
                'email'              => $pending->email,
                'password'           => $pending->password_hash,
                'phone'              => $pending->phone,
                'country'            => $pending->country,
                'birth_date'         => $pending->birth_date,
                'biometrics_enabled' => $pending->wants_biometrics,
                'email_verified_at'  => now(),
            ]);

            // Parse phone code and number
            preg_match('/^\+(\d{1,3})(\d+)$/', $pending->phone, $matches);
            $phone_code = $matches[1] ?? '';
            $phone_number = $matches[2] ?? '';

            // Create profile
            $user->profile()->create([
                'first_name'          => $pending->first_name,
                'last_name'           => $pending->last_name,
                'birth_date'          => $pending->birth_date,
                'country'             => $pending->country,
                'phone_code'          => $phone_code,
                'phone_number'        => $phone_number,
                'avatar_path'         => null,
                'is_verified_identity'=> false,
                'is_verified_address' => false,
            ]);

            // Delete pending registration
            $pending->delete();

            // Log in the user
            auth()->login($user);
        });

        return redirect()->route('dashboard')->with('status', 'Account created successfully!');
    }

    /**
     * Resend OTP.
     */
    public function resend(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email']
        ]);

        $pending = PendingRegistration::where('email', $data['email'])->firstOrFail();

        // ✅ Allow resend only if at least 60 seconds passed since last update
        $secondsSinceLast = now()->diffInSeconds($pending->updated_at);
        if ($secondsSinceLast < 60) {
            $secondsLeft = 60 - $secondsSinceLast;
            return back()->withErrors([
                'email' => "Please wait {$secondsLeft} seconds before requesting a new code."
            ]);
        }

        // Generate new OTP
        $otp = (string) random_int(100000, 999999);

        $pending->update([
            'otp_hash'       => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5),
            'otp_attempts'   => 0,
        ]);

        Mail::to($pending->email)->send(new VerifyRegistrationMail($otp));

        return back()->with('status', 'A new code has been sent. It expires in 5 minutes.');
    }
}
