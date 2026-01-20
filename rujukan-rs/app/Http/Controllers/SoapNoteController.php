<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\SoapNote;
use Illuminate\Http\Request;

class SoapNoteController extends Controller
{
    public function store(Request $request, Examination $examination)
    {
        $data = $request->validate([
            'subjective' => 'nullable|string',
            'objective' => 'nullable|string',
            'assessment' => 'nullable|string',
            'plan' => 'nullable|string',
        ]);

        SoapNote::updateOrCreate(
            ['examination_id' => $examination->id],
            $data
        );

        return back();
    }
}