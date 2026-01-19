<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamDrug extends Model
{
    protected $table = 'exam_drugs';

    protected $fillable = [
        'examination_id',
        'drug_id',
        'qty',
        'price',
        'dosage_instruction',
        'note',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function drug()
    {
        return $this->belongsTo(CatalogDrug::class, 'drug_id');
    }
}