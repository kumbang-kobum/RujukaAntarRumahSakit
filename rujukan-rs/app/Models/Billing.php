<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'visit_id', 'subtotal', 'discount', 'total', 'closed_at', 'closed_by_user_id'
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(BillingItem::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}