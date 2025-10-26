<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'country',
        'phone_code',
        'phone_number',
        'avatar_path',
        'identity_document_path',
        'address_document_path',
        'identity_status',   // pending | verified | rejected
        'address_status',    // pending | verified | rejected
        'promo_code'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // A profile belongs to one user
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Avatar URL accessor
    
    public function getAvatarUrlAttribute()
    {
        return $this->avatar_path 
            ? Storage::disk('public')->url($this->avatar_path) 
            : asset('images/default-avatar.png');
    }

    // Identity document URL accessor
    
    public function getIdentityDocumentUrlAttribute()
    {
        return $this->identity_document_path
            ? Storage::disk('public')->url($this->identity_document_path)
            : null;
    }

    // Address document URL accessor
    
    public function getAddressDocumentUrlAttribute()
    {
        return $this->address_document_path
            ? Storage::disk('public')->url($this->address_document_path)
            : null;
    }
}
