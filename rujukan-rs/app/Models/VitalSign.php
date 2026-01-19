<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $table = 'vital_signs';

    protected $fillable = [
        'examination_id',
        'systolic',
        'diastolic',
        'pulse',
        'resp_rate',
        'temp',
        'spo2',
        'weight',
        'height',
        'pain_scale',
    ];

    protected $casts = [
        'systolic' => 'integer',
        'diastolic' => 'integer',
        'pulse' => 'integer',
        'resp_rate' => 'integer',
        'temp' => 'decimal:1',
        'spo2' => 'integer',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'pain_scale' => 'integer',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}