<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    
    // Mass assignable attributes
    
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'birth_date',
        'password',
        'promo_code',
        'phone',
        'country',
        'biometrics_enabled',
        'email_verified_at',
    ];

    
    // Hidden attributes
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    // Attribute casting
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'biometrics_enabled' => 'boolean',
    ];

    // Relationships
    
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionsViaAccounts()
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }

    public function notifications()
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable');
    }

    
    // Helper: Full name
    
    public function fullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}") ?: $this->name;
    }
}

