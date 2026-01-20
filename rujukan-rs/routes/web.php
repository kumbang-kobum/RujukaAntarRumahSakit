<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\SoapNoteController;
use App\Http\Controllers\ExamProcedureController;
use App\Http\Controllers\ExamDrugController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('patients', PatientController::class)->only([
        'index','create','store','show'
    ]);

    Route::resource('visits', VisitController::class)->only([
        'index','create','store','show'
    ]);

    Route::post(
    '/visits/{visit}/examinations',
    [ExaminationController::class, 'store']
)->name('examinations.store');

Route::post(
    '/examinations/{examination}/vital-signs',
    [VitalSignController::class, 'store']
)->name('vital-signs.store');
});

Route::post(
    '/examinations/{examination}/soap',
    [SoapNoteController::class, 'store']
)->name('soap.store');

Route::post('/examinations/{examination}/procedures', [ExamProcedureController::class, 'store'])
  ->name('exam-procedures.store');

 Route::post('/examinations/{examination}/drugs', [ExamDrugController::class, 'store'])
  ->name('exam-drugs.store');
  


require __DIR__.'/auth.php';
