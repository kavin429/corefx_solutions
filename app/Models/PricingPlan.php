<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'leverage',
        'min_lot_size',
        'starting_pips',
        'swap',
        'commission',
        'spread', // newly added column
    ];
}
