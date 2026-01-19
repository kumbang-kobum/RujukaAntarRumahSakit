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
            'systolic' => 'nullable|integer',
            'diastolic' => 'nullable|integer',
            'pulse' => 'nullable|integer',
            'resp_rate' => 'nullable|integer',
            'temp' => 'nullable|numeric',
            'spo2' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'pain_scale' => 'nullable|integer',
        ]);

        VitalSign::updateOrCreate(
            ['examination_id' => $examination->id],
            $data
        );

        return back()->with('success', 'TTV disimpan.');
    }
}