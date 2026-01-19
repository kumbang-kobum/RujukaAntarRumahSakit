<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Examination;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function store(Request $request, Visit $visit)
    {
        $exam = Examination::create([
            'visit_id' => $visit->id,
            'examiner_user_id' => $request->user()->id,
            'examiner_hospital_id' => $request->user()->hospital_id,
            'examined_at' => now(),
            'status' => 'draft',
        ]);

        return back()->with('success', 'Pemeriksaan dibuat.');
    }
}