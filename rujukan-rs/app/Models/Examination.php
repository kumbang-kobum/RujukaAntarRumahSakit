<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $fillable = [
        'visit_id',
        'examiner_user_id',
        'examiner_hospital_id',
        'examined_at',
        'status',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_user_id');
    }

    public function vitalSign()
    {
        return $this->hasOne(VitalSign::class);
    }

    public function soapNote()
    {
        return $this->hasOne(\App\Models\SoapNote::class);
    }

    public function procedures()
    {
        return $this->hasMany(\App\Models\ExamProcedure::class);
    }

    public function drugs()
    {
        return $this->hasMany(\App\Models\ExamDrug::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\ClinicalDocument::class);
    }

    protected $casts = [
    'examined_at' => 'datetime',
    ];
}