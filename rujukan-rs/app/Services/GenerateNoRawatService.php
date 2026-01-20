<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class GenerateNoRawatService
{
    public function generate(int $hospitalId): string
    {
        $date = now()->startOfDay();
        $dateKey = $date->format('Y-m-d');
        $prefix = $date->format('Y/m/d');

        return DB::transaction(function () use ($hospitalId, $dateKey, $prefix) {
            $row = DB::table('no_rawat_counters')
                ->where('hospital_id', $hospitalId)
                ->where('date', $dateKey)
                ->lockForUpdate()
                ->first();

            if (!$row) {
                DB::table('no_rawat_counters')->insert([
                    'hospital_id' => $hospitalId,
                    'date' => $dateKey,
                    'last_number' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $num = 1;
            } else {
                $num = $row->last_number + 1;
                DB::table('no_rawat_counters')
                    ->where('id', $row->id)
                    ->update([
                        'last_number' => $num,
                        'updated_at' => now(),
                    ]);
            }

            return $prefix . '/' . str_pad($num, 6, '0', STR_PAD_LEFT);
        });
    }
}