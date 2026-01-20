<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'hospital_id',
        'department_id',
        'patient_id',
        'no_rawat',
        'visit_date',
        'status',
        'created_by_user_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}