<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogProcedure extends Model
{
    protected $fillable = ['hospital_id','code','name','unit','default_price','is_active'];
}