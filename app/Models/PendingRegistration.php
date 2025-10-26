<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    protected $fillable = [
        'first_name','last_name','email','birth_date','country','phone',
        'password_hash','promo_code','wants_biometrics',
        'otp_hash','otp_expires_at','otp_attempts'
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'birth_date'     => 'date',
        'wants_biometrics'=> 'boolean',
    ];
}
