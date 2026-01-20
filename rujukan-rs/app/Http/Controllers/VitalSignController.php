<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\VitalSign;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    public function store(Request $request, Examination $examination)
    {
        $data = $request->validate([
            'systolic' => 'nullable|integer|min:0',
            'diastolic' => 'nullable|integer|min:0',
            'pulse' => 'nullable|integer|min:0',
            'resp_rate' => 'nullable|integer|min:0',
            'temperature' => 'nullable|numeric',
            'spo2' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'pain_scale' => 'nullable|integer|min:0|max:10',
        ]);

        VitalSign::updateOrCreate(
            ['examination_id' => $examination->id],
            $data
        );

        return back();
    }
}