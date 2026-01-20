<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Referral;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReferralController extends Controller
{
    // Form rujukan dari Visit detail
    public function create(Visit $visit)
    {
        $user = auth()->user();

        // RS tujuan: semua RS selain RS user (MVP)
        $hospitals = Hospital::orderBy('name')->get();

        return Inertia::render('Referrals/Create', [
            'visit' => $visit->load('patient'),
            'hospitals' => $hospitals,
        ]);
    }

    public function store(Request $request, Visit $visit)
    {
        $user = $request->user();

        $data = $request->validate([
            'to_hospital_id' => 'required|exists:hospitals,id',
            'to_department_id' => 'nullable|exists:departments,id',
            'to_user_id' => 'nullable|exists:users,id',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($visit, $user, $data) {

            Referral::create([
                'visit_id' => $visit->id,

                'from_hospital_id' => $user->hospital_id,
                'from_user_id' => $user->id,
                'from_department_id' => $visit->department_id,

                'to_hospital_id' => $data['to_hospital_id'],
                'to_department_id' => $data['to_department_id'] ?? null,
                'to_user_id' => $data['to_user_id'] ?? null,

                'status' => 'sent',
                'reason' => $data['reason'] ?? null,
                'notes' => $data['notes'] ?? null,
                'sent_at' => now(),
            ]);
            \App\Jobs\SendReferralWhatsAppJob::dispatch($ref->id);

            // Update status visit (opsional tapi sesuai alur kamu)
            $visit->update(['status' => 'referred']);

            // Tambahkan participant dokter tujuan (jika dipilih)
            if (!empty($data['to_user_id'])) {
                $exists = DB::table('visit_participants')
                    ->where('visit_id', $visit->id)
                    ->where('user_id', $data['to_user_id'])
                    ->exists();

                if (!$exists) {
                    $toUser = User::findOrFail($data['to_user_id']);

                    DB::table('visit_participants')->insert([
                        'visit_id' => $visit->id,
                        'user_id' => $toUser->id,
                        'hospital_id' => $toUser->hospital_id,
                        'role_in_visit' => 'doctor',
                        'joined_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return redirect()->route('visits.show', $visit->id);
    }

    // Endpoint untuk dropdown dependensi (departments & doctors)
    public function options(Request $request)
    {
        $hospitalId = $request->integer('hospital_id');

        $departments = Department::where('hospital_id', $hospitalId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id','name']);

        $doctors = User::where('hospital_id', $hospitalId)
            ->orderBy('name')
            ->get(['id','name','email']);

        return response()->json([
            'departments' => $departments,
            'doctors' => $doctors,
        ]);
    }
}