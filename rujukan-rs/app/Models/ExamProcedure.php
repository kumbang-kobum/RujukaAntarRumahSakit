<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamProcedure extends Model
{
    protected $fillable = [
        'examination_id','procedure_id','qty','price','note','performed_by_user_id'
    ];

    public function procedure()
    {
        return $this->belongsTo(CatalogProcedure::class, 'procedure_id');
    }
}