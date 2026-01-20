<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ClinicalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClinicalDocumentController extends Controller
{
    public function store(Request $request, Examination $examination)
    {
        $data = $request->validate([
            'type' => 'required|in:lab,radiology,other',
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:5120', // 5MB
        ]);

        $path = $request->file('file')->store('clinical-documents');

        ClinicalDocument::create([
            'examination_id' => $examination->id,
            'type' => $data['type'],
            'title' => $data['title'],
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'uploaded_by_user_id' => $request->user()->id,
        ]);

        return back();
    }

    public function download(ClinicalDocument $document)
    {
        return Storage::download($document->file_path, $document->original_name);
    }
}