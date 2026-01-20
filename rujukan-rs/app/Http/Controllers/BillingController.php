<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Visit;
use App\Services\GenerateBillingService;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class BillingController extends Controller
{
    public function close(Visit $visit, GenerateBillingService $svc)
    {
        Gate::authorize('view', $visit);

        $billing = $svc->generateAndCloseVisit($visit, auth()->id());

        return redirect()->route('billings.show', $billing->id);
    }

    public function show(Billing $billing)
    {
        // akses billing mengikuti akses visit
        Gate::authorize('view', $billing->visit);

        $billing->load('items', 'visit.patient');

        return Inertia::render('Billings/Show', [
            'billing' => $billing,
        ]);
    }

    //cetak pdf billing
    public function pdf(Billing $billing)
    {
        Gate::authorize('view', $billing->visit);

        $billing->load('items', 'visit.patient');

        $pdf = Pdf::loadView('pdf.billing', [
            'billing' => $billing,
        ]);

        return $pdf->download('nota-' . $billing->visit->no_rawat . '.pdf');
    }
}