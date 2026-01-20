<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitPolicy
{
    public function view(User $user, Visit $visit): bool
    {
        // RS asal
        if ($user->hospital_id === $visit->hospital_id) {
            return true;
        }

        // Participant
        $isParticipant = DB::table('visit_participants')
            ->where('visit_id', $visit->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($isParticipant) {
            return true;
        }

        // RS tujuan rujukan
        $hasReferral = $visit->referrals()
            ->where('to_hospital_id', $user->hospital_id)
            ->whereIn('status', ['sent','accepted','completed'])
            ->exists();

        return $hasReferral;
    }
}