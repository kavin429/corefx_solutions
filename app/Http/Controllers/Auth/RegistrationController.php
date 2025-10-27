<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PendingRegistration;
use App\Mail\VerifyRegistrationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('auth.signup');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'first_name'       => ['required','string','max:100'],
            'last_name'        => ['required','string','max:100'],
            'email'            => ['required','email','max:255'],
            'birth_date'       => ['required','date','before_or_equal:'.now()->subYears(18)->toDateString()],
            'country'          => ['required','string','max:100'],
            'phone_code'       => ['required','string','max:6'],
            'phone_number'     => ['required','string','max:20'],
            'password'         => ['required','confirmed','min:8'],
            'promo_code'       => ['nullable','string','max:50'],
            'wants_biometrics' => ['nullable','boolean'],
            'g-recaptcha-response' => ['nullable','captcha'],
        ]);

        // Build E.164 like phone
        $fullPhone = $data['phone_code'] . preg_replace('/\D+/', '', $data['phone_number']);

        // Remove any existing pending row for same email
        PendingRegistration::where('email', $data['email'])->delete();

        // Generate 6-digit otp
        $otp = (string) random_int(100000, 999999);

        $pending = PendingRegistration::create([
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'email'            => $data['email'],
            'birth_date'       => $data['birth_date'],
            'country'          => $data['country'],
            'phone'            => $fullPhone,
            'password_hash'    => Hash::make($data['password']), // hashed now
            'promo_code'       => $data['promo_code'] ?? null,
            'wants_biometrics' => (bool)($data['wants_biometrics'] ?? false),

            'otp_hash'         => Hash::make($otp),
            'otp_expires_at'   => now()->addMinutes(5),
            'otp_attempts'     => 0,
        ]);

        // Send OTP email (synchronous). In production queue this.
        Mail::to($pending->email)->send(new VerifyRegistrationMail($otp));

        // Redirect to OTP page with email param
        return redirect()->route('otp.show', ['email' => $pending->email])
            ->with('status', 'We sent a 6-digit code to your email. It expires in 5 minutes.');
    }
}
