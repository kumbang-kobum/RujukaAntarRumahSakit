<?php

namespace App\Jobs;

use App\Models\Referral;
use App\Services\GoWaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReferralWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $referralId)
    {
    }

    public function handle(GoWaService $goWa): void
    {
        $ref = Referral::with([
            'visit.patient',
            'toHospital',
            'toDepartment',
            'toUser',
        ])->find($this->referralId);

        if (!$ref) return;

        $visit = $ref->visit;
        $patient = $visit->patient;

        // 1) Kirim ke dokter tujuan (kalau ada)
        if ($ref->toUser && !empty($ref->toUser->phone_whatsapp)) {
            $msg = $this->buildDoctorMessage($ref);
            $res = $goWa->sendMessage($ref->toUser->phone_whatsapp, $msg);

            if (!$res['ok']) {
                Log::warning('GoWA doctor send failed', [
                    'referral_id' => $ref->id,
                    'to_user_id' => $ref->to_user_id,
                    'res' => $res,
                ]);
            }
        }

        // 2) Kirim ke pasien (kalau ada no hp)
        if ($patient && !empty($patient->phone)) {
            $msg = $this->buildPatientMessage($ref);
            $res = $goWa->sendMessage($patient->phone, $msg);

            if (!$res['ok']) {
                Log::warning('GoWA patient send failed', [
                    'referral_id' => $ref->id,
                    'patient_id' => $patient->id,
                    'res' => $res,
                ]);
            }
        }
    }

    private function buildDoctorMessage(Referral $ref): string
    {
        $visit = $ref->visit;
        $patient = $visit->patient;

        $toDept = $ref->toDepartment?->name ?? '-';
        $toHospital = $ref->toHospital?->name ?? '-';

        $link = url("/visits/{$visit->id}");

        return
            "RUJUKAN PASIEN\n"
            . "No Rawat: {$visit->no_rawat}\n"
            . "Pasien: {$patient->name}\n"
            . "Tujuan: {$toHospital} / {$toDept}\n"
            . "Alasan: " . ($ref->reason ?? '-') . "\n"
            . "Link: {$link}";
    }

    private function buildPatientMessage(Referral $ref): string
    {
        $visit = $ref->visit;
        $patient = $visit->patient;

        $toDept = $ref->toDepartment?->name ?? '-';
        $toHospital = $ref->toHospital?->name ?? '-';

        return
            "Halo {$patient->name},\n"
            . "Anda dirujuk ke {$toHospital} (Poli: {$toDept}).\n"
            . "No Rawat: {$visit->no_rawat}\n"
            . "Silakan menunggu informasi lanjutan dari petugas.";
    }
}