<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    protected $fillable = [
        'billing_id', 'type', 'name', 'price', 'qty', 'total', 'ref_type', 'ref_id'
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}