<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ExamProcedure;
use App\Models\CatalogProcedure;
use Illuminate\Http\Request;

class ExamProcedureController extends Controller
{
    public function store(Request $request, Examination $examination)
    {
        $data = $request->validate([
            'procedure_id' => 'required|exists:catalog_procedures,id',
            'qty' => 'required|numeric|min:1',
        ]);

        $procedure = CatalogProcedure::findOrFail($data['procedure_id']);

        ExamProcedure::create([
            'examination_id' => $examination->id,
            'procedure_id' => $procedure->id,
            'qty' => $data['qty'],
            'price' => $procedure->default_price,
            'performed_by_user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Tindakan ditambahkan.');
    }
}