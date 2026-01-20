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
            'nik' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'address_detail' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
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

    //history pasien
    public function history(Patient $patient)
    {
        $visits = Visit::with([
                'examinations.procedures.procedure',
                'examinations.drugs.drug',
            ])
            ->where('patient_id', $patient->id)
            ->orderByDesc('visit_date')
            ->get();

        return Inertia::render('Patients/History', [
            'patient' => $patient,
            'visits' => $visits,
        ]);
    }
}