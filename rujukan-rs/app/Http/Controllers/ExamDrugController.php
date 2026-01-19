<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ExamDrug;
use App\Models\CatalogDrug;
use Illuminate\Http\Request;

class ExamDrugController extends Controller
{
    public function store(Request $request, Examination $examination)
    {
        $data = $request->validate([
            'drug_id' => 'required|exists:catalog_drugs,id',
            'qty' => 'required|numeric|min:1',
        ]);

        $drug = CatalogDrug::findOrFail($data['drug_id']);

        ExamDrug::create([
            'examination_id' => $examination->id,
            'drug_id' => $drug->id,
            'qty' => $data['qty'],
            'price' => $drug->default_price,
        ]);

        return back()->with('success', 'Obat ditambahkan.');
    }
}