<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    
    // The table associated with the model.
    
    protected $table = 'accounts';

    // The attributes that are mass assignable.
    
    protected $fillable = [
        'user_id',
        'live_id',
        'account_name',
        'type',
        'currency',
        'balance',
        'pnl',
    ];

    
    // Relationships
    

    // Each account belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Example: if you want to link transactions later
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
