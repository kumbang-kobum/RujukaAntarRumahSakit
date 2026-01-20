<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'visit_id',
        'from_hospital_id','from_user_id','from_department_id',
        'to_hospital_id','to_department_id','to_user_id',
        'status','reason','notes',
        'sent_at','accepted_at','completed_at',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function toHospital()
    {
        return $this->belongsTo(Hospital::class, 'to_hospital_id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}