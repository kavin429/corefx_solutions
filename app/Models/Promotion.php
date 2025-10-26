<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title', 'description',
        'popup_enabled', 'popup_image',
        'poster_large', 'poster_medium', 'poster_small',
    ];
}
