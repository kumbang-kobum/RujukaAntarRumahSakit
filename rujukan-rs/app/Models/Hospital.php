<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'settings_json',
    ];

    protected $casts = [
        'settings_json' => 'array',
    ];
}