<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogProcedure extends Model
{
    protected $table = 'catalog_procedures';

    protected $fillable = [
        'hospital_id',
        'code',
        'name',
        'default_price',
        'unit',
        'is_active',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}