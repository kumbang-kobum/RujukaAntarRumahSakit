<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Referral;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $hospitalId = auth()->user()->hospital_id;

        $patientsInHospital = Visit::where('hospital_id', $hospitalId)
            ->distinct('patient_id')
            ->count('patient_id');

        return Inertia::render('Dashboard', [
            'stats' => [
                'patients' => $patientsInHospital,

                'visitsToday' => Visit::where('hospital_id', $hospitalId)
                    ->whereDate('visit_date', today())
                    ->count(),

                'activeVisits' => Visit::where('hospital_id', $hospitalId)
                    ->whereNull('closed_at')
                    ->count(),

                'referralsToday' => Referral::whereHas('visit', function ($q) use ($hospitalId) {
                    $q->where('hospital_id', $hospitalId);
                })->whereDate('created_at', today())->count(),
            ],
        ]);
    }
}