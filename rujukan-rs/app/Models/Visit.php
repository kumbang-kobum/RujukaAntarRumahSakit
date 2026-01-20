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

    public function getTotalCostAttribute()
    {
        $total = 0;

        foreach ($this->examinations as $exam) {
            foreach ($exam->procedures as $p) {
                $total += $p->qty * $p->price;
            }
            foreach ($exam->drugs as $d) {
                $total += $d->qty * $d->price;
            }
        }

        return $total;
    }

    public function referrals()
    {
        return $this->hasMany(\App\Models\Referral::class);
    }
}