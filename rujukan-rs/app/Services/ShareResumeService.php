<?php

namespace App\Services;

use App\Models\SharedLink;
use App\Models\Visit;
use Illuminate\Support\Str;

class ShareResumeService
{
    public function createForVisit(Visit $visit, int $expireHours = 72): SharedLink
    {
        // reuse token kalau masih aktif
        $existing = SharedLink::where('type', 'resume_pdf')
            ->where('visit_id', $visit->id)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();

        if ($existing) {
            return $existing;
        }

        return SharedLink::create([
            'token' => Str::random(60),
            'type' => 'resume_pdf',
            'visit_id' => $visit->id,
            'expires_at' => now()->addHours($expireHours),
        ]);
    }
}