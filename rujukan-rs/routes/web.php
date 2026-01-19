<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pemeriksaan
    Route::post('/visits/{visit}/examinations', [ExaminationController::class, 'store'])
        ->name('examinations.store');

    // TTV
    Route::post('/examinations/{examination}/vital-signs', [VitalSignController::class, 'store'])
        ->name('vital-signs.store');

    // SOAP
    Route::post('/examinations/{examination}/soap', [SoapNoteController::class, 'store'])
        ->name('soap.store');

    // Tindakan
    Route::post('/examinations/{examination}/procedures', [ExamProcedureController::class, 'store'])
        ->name('exam-procedures.store');

    // Obat
    Route::post('/examinations/{examination}/drugs', [ExamDrugController::class, 'store'])
        ->name('exam-drugs.store');

require __DIR__.'/auth.php';
