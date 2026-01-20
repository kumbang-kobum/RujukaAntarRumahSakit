<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoapNote extends Model
{
    protected $fillable = [
        'examination_id',
        'subjective',
        'objective',
        'assessment',
        'plan',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}