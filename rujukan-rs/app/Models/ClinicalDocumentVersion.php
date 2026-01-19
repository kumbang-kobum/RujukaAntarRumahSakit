<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalDocumentVersion extends Model
{
    protected $fillable = [
        'clinical_document_id','version_no',
        'file_path','file_name','mime_type','file_size','sha256',
        'uploaded_by_user_id'
    ];

    public function document() { return $this->belongsTo(ClinicalDocument::class, 'clinical_document_id'); }
}