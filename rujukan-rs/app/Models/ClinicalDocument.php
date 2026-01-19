<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'visit_id','examination_id',
        'uploaded_by_user_id','uploader_hospital_id',
        'category','title','document_date',
        'file_path','file_name','mime_type','file_size','sha256',
        'visibility',
    ];

    public function visit() { return $this->belongsTo(Visit::class); }
    public function versions() { return $this->hasMany(ClinicalDocumentVersion::class); }
}