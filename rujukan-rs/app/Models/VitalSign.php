<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $fillable = [
        'examination_id',
        'systolic',
        'diastolic',
        'pulse',
        'resp_rate',
        'temperature',
        'spo2',
        'weight',
        'height',
        'pain_scale',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}