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
        'live_id_assigned_at', // ✅ add this line
    ];

    // Casts
    protected $casts = [
        'live_id_assigned_at' => 'datetime', // ✅ ensures Carbon date formatting
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
