<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalDocument extends Model
{
    protected $fillable = [
        'examination_id',
        'type',
        'title',
        'file_path',
        'original_name',
        'uploaded_by_user_id',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}