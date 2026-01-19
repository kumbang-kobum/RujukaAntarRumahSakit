<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $fillable = [
        'visit_id','examiner_user_id','examiner_hospital_id','examined_at','status'
    ];

    public function visit() { return $this->belongsTo(Visit::class); }
    public function vital() { return $this->hasOne(VitalSign::class); }
    public function soap() { return $this->hasOne(SoapNote::class); }
    public function procedures() { return $this->hasMany(ExamProcedure::class); }
    public function drugs() { return $this->hasMany(ExamDrug::class); }
}