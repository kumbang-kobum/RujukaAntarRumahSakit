<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::orderByDesc('created_at')->paginate(10);

        return Inertia::render('Patients/Index', [
            'patients' => $patients
        ]);
    }

    public function create()
    {
        return Inertia::render('Patients/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => 'nullable|string',
            'name' => 'required|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'address_detail' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $patient = Patient::create($data);

        return redirect()->route('patients.show', $patient->id);
    }

    public function show(Patient $patient)
    {
        return Inertia::render('Patients/Show', [
            'patient' => $patient,
            'visits' => $patient->visits()->latest()->get()
        ]);
    }
}