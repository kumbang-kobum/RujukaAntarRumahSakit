<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'hospital_id','department_id','patient_id','no_rawat','visit_date',
        'status','linked_visit_id','created_by_user_id','closed_at'
    ];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function examinations() { return $this->hasMany(Examination::class); }
    public function documents() { return $this->hasMany(ClinicalDocument::class); }
}