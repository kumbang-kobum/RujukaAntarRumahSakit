<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamDrug extends Model
{
    protected $fillable = ['examination_id','drug_id','qty','price','note'];

    public function drug()
    {
        return $this->belongsTo(CatalogDrug::class, 'drug_id');
    }
}