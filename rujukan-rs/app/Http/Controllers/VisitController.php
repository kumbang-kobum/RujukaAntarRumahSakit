<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Patient;
use App\Models\Department;
use App\Models\CatalogProcedure;
use App\Models\CatalogDrug;
use App\Services\GenerateNoRawatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use App\Models\SharedLink;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('patient')
            ->latest('visit_date')
            ->paginate(10);

        return Inertia::render('Visits/Index', [
            'visits' => $visits,
        ]);
    }

    public function create()
    {
        return Inertia::render('Visits/Create', [
            'patients' => Patient::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, GenerateNoRawatService $noRawat)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = $request->user();

        $visit = DB::transaction(function () use ($data, $user, $noRawat) {
            $no = $noRawat->generate($user->hospital_id);

            $visit = Visit::create([
                'hospital_id' => $user->hospital_id,
                'department_id' => $data['department_id'],
                'patient_id' => $data['patient_id'],
                'no_rawat' => $no,
                'visit_date' => now(),
                'status' => 'registered',
                'created_by_user_id' => $user->id,
            ]);

            DB::table('visit_participants')->insert([
                'visit_id' => $visit->id,
                'user_id' => $user->id,
                'hospital_id' => $user->hospital_id,
                'role_in_visit' => 'doctor',
                'joined_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $visit;
        });

        return redirect()->route('visits.show', $visit->id);
    }

    public function show(Visit $visit)
    {
        $this->authorize('view', $visit);
        $visit->load('patient', 'billing', 'referrals.toHospital', 'referrals.toDepartment', 'referrals.toUser');

        $examinations = $visit->examinations()
            ->with([
                'examiner',
                'vitalSign',
                'soapNote',
                'procedures.procedure',
                'drugs.drug',
                'documents.uploader',
            ])
            ->orderByDesc('examined_at')
            ->get();

        $visit->setRelation('examinations', $examinations);

        $catalogProcedures = CatalogProcedure::where('hospital_id', auth()->user()->hospital_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $catalogDrugs = CatalogDrug::where('hospital_id', auth()->user()->hospital_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Visits/Show', [
            'visit' => $visit,
            'examinations' => $examinations,
            'catalogProcedures' => $catalogProcedures,
            'catalogDrugs' => $catalogDrugs,
        ]);
    }

    public function resumePdf(Visit $visit)
    {
        Gate::authorize('view', $visit);

        $visit->load([
            'patient',
            'hospital',
            'department',
            'examinations.examiner',
            'examinations.vitalSign',
            'examinations.soapNote',
            'examinations.procedures.procedure',
            'examinations.drugs.drug',
            'examinations.documents.uploader',
            'referrals.toHospital',
            'referrals.toDepartment',
            'referrals.toUser',
        ]);

        $pdf = Pdf::loadView('pdf.resume-medis', [
            'visit' => $visit,
        ])->setPaper('A4', 'portrait');

        return $pdf->download(
            'resume-medis-' . str_replace('/', '-', $visit->no_rawat) . '.pdf'
        );
    }
    
    public function resumePreview(Visit $visit)
    {
        Gate::authorize('view', $visit);

        $visit->load([
            'patient',
            'hospital',
            'department',
            'examinations.examiner',
            'examinations.vitalSign',
            'examinations.soapNote',
            'examinations.procedures.procedure',
            'examinations.drugs.drug',
            'examinations.documents.uploader',
            'referrals.toHospital',
            'referrals.toDepartment',
            'referrals.toUser',
        ]);

        return view('resume.preview', [
            'visit' => $visit,
        ]);
    }

    //kirim GoWA
    public function sharedResumePdf(string $token)
    {
        $link = SharedLink::where('token', $token)
            ->where('type', 'resume_pdf')
            ->firstOrFail();

        if ($link->expires_at && now()->greaterThan($link->expires_at)) {
            abort(Response::HTTP_GONE, 'Link expired');
        }

        $visit = $link->visit()->firstOrFail();

        // load data sama seperti resumePdf
        $visit->load([
            'patient',
            'hospital',
            'department',
            'examinations.examiner',
            'examinations.vitalSign',
            'examinations.soapNote',
            'examinations.procedures.procedure',
            'examinations.drugs.drug',
            'examinations.documents.uploader',
            'referrals.toHospital',
            'referrals.toDepartment',
            'referrals.toUser',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.resume-medis', [
            'visit' => $visit,
        ])->setPaper('A4', 'portrait');

        // stream inline (GoWA biasanya bisa fetch)
        return $pdf->stream(
            'resume-medis-' . str_replace('/', '-', $visit->no_rawat) . '.pdf'
        );
    }

}