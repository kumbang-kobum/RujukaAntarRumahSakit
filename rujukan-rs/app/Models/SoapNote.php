<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoapNote extends Model
{
    protected $table = 'soap_notes';

    protected $fillable = [
        'examination_id',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'signed_at',
        'signed_by_user_id',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by_user_id');
    }
}