<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamProcedure extends Model
{
    protected $table = 'exam_procedures';

    protected $fillable = [
        'examination_id',
        'procedure_id',
        'qty',
        'price',
        'note',
        'performed_by_user_id',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function procedure()
    {
        return $this->belongsTo(CatalogProcedure::class, 'procedure_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }
}