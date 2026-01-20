<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class GenerateBillingService
{
    public function generateAndCloseVisit(Visit $visit, int $closedByUserId = null): Billing
    {
        return DB::transaction(function () use ($visit, $closedByUserId) {

            // Cegah double close
            if ($visit->billing) {
                return $visit->billing()->with('items')->first();
            }

            // Load semua yang dibutuhkan
            $visit->load([
                'examinations.procedures.procedure',
                'examinations.drugs.drug',
            ]);

            $billing = Billing::create([
                'visit_id' => $visit->id,
                'subtotal' => 0,
                'discount' => 0,
                'total' => 0,
                'closed_at' => now(),
                'closed_by_user_id' => $closedByUserId,
            ]);

            $subtotal = 0;

            foreach ($visit->examinations as $exam) {

                // TINDAKAN
                foreach ($exam->procedures as $p) {
                    $lineTotal = (float) $p->qty * (float) $p->price;

                    $billing->items()->create([
                        'type' => 'procedure',
                        'name' => $p->procedure?->name ?? 'Tindakan',
                        'price' => $p->price,
                        'qty' => $p->qty,
                        'total' => $lineTotal,
                        'ref_type' => get_class($p),
                        'ref_id' => $p->id,
                    ]);

                    $subtotal += $lineTotal;
                }

                // OBAT
                foreach ($exam->drugs as $d) {
                    $lineTotal = (float) $d->qty * (float) $d->price;

                    $billing->items()->create([
                        'type' => 'drug',
                        'name' => $d->drug?->name ?? 'Obat',
                        'price' => $d->price,
                        'qty' => $d->qty,
                        'total' => $lineTotal,
                        'ref_type' => get_class($d),
                        'ref_id' => $d->id,
                    ]);

                    $subtotal += $lineTotal;
                }
            }

            $discount = 0;
            $total = $subtotal - $discount;

            $billing->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            $visit->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);

            return $billing->load('items');
        });
    }
}