<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogDrug extends Model
{
    protected $fillable = ['hospital_id','code','name','unit','default_price','is_active'];
}