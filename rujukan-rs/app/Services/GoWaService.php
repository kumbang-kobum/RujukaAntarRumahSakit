<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoWaService
{
    public function sendMessage(string $phone, string $message): array
    {
        // Normalisasi nomor: cuma digit
        $phone = preg_replace('/\D+/', '', $phone);

        // jika nomor mulai 0, ubah ke 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // jika mulai 8, anggap nomor lokal, tambah 62
        if (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        // optional token
        if (config('gowa.token')) {
            $req = $req->withToken(config('gowa.token'));
        }

        $resp = $req->post($url, [
            'phone' => $phone,
            'message' => $message,
        ]);

        return [
            'ok' => $resp->successful(),
            'status' => $resp->status(),
            'body' => $resp->json(),
            'raw' => $resp->body(),
        ];
    }
}