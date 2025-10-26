<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin'; // Important for auth

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture', // ✅ add this
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Accessor for profile picture (so you can easily get full URL)
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        return asset('pics/client2.png'); // fallback image
    }


}
