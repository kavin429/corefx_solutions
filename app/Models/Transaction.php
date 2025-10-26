<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.

protected $fillable = [
    'user_id',
    'account_id',
    'type',
    'amount',
    'method',
    'status',
    'beneficiary_name',
    'bank_name',
    'account_number',
    'ifsc',
    'bank_address',
    'xynder_id',
    'binance_id',
    'upi_id',       // <-- add this
    'network_id',
    'note',
    'screenshot_path',
];


    // Relationships

    // Each transaction belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each transaction may belong to a trading account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Scopes
    

    // Filter deposits
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    // Filter withdrawals
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdraw');
    }

    // Filter by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Filter by method
    public function scopeMethod($query, $method)
    {
        return $query->where('method', $method);
    }
}
