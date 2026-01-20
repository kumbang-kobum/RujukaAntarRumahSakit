<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\SoapNoteController;
use App\Http\Controllers\ExamProcedureController;
use App\Http\Controllers\ExamDrugController;
use App\Http\Controllers\ClinicalDocumentController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // Patients
    Route::resource('patients', PatientController::class)->only([
        'index','create','store','show'
    ]);
    Route::get('/patients/{patient}/history', [PatientController::class, 'history'])
        ->name('patients.history');

    // Visits
    Route::resource('visits', VisitController::class)->only([
        'index','create','store','show'
    ]);

    // Examinations
    Route::post('/visits/{visit}/examinations', [ExaminationController::class, 'store'])
        ->name('examinations.store');

    // TTV
    Route::post('/examinations/{examination}/vital-signs', [VitalSignController::class, 'store'])
        ->name('vital-signs.store');

    // SOAP
    Route::post('/examinations/{examination}/soap', [SoapNoteController::class, 'store'])
        ->name('soap.store');

    // Procedures (Tindakan)
    Route::post('/examinations/{examination}/procedures', [ExamProcedureController::class, 'store'])
        ->name('exam-procedures.store');

    // Drugs (Obat)
    Route::post('/examinations/{examination}/drugs', [ExamDrugController::class, 'store'])
        ->name('exam-drugs.store');

    // Documents (Lab/Radiologi)
    Route::post('/examinations/{examination}/documents', [ClinicalDocumentController::class, 'store'])
        ->name('documents.store');
    Route::get('/documents/{document}/download', [ClinicalDocumentController::class, 'download'])
        ->name('documents.download');

    // Referrals (Rujukan)
    Route::get('/visits/{visit}/referrals/create', [ReferralController::class, 'create'])
        ->name('referrals.create');
    Route::post('/visits/{visit}/referrals', [ReferralController::class, 'store'])
        ->name('referrals.store');
    Route::get('/referrals/options', [ReferralController::class, 'options'])
        ->name('referrals.options');

    // Billings (Tagihan)
    Route::post('/visits/{visit}/close', [BillingController::class, 'close'])
    ->name('visits.close');

    Route::get('/billings/{billing}', [BillingController::class, 'show'])
        ->name('billings.show');
        
    Route::get('/billings/{billing}/pdf', [BillingController::class, 'pdf'])
    ->name('billings.pdf');
    
    //resume pdf pasien
    Route::get('/visits/{visit}/resume', [VisitController::class, 'resumePreview'])
    ->name('visits.resume.preview');

    Route::get('/visits/{visit}/resume-pdf', [VisitController::class, 'resumePdf'])
    ->name('visits.resume.pdf');

    // (opsional) profile kalau kamu pakai
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';