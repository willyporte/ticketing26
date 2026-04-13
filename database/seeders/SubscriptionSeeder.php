<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Seed 2 subscription attive, una per company.
     *
     * I minuti_remaining sono già scalati in base alle TimeEntry inserite nello STEP 7:
     * - Acme:  Piano Pro  (2000 min) → 260 min spesi → 1740 residui
     * - Beta:  Piano Base (500 min)  → 35 min spesi  → 465 residui
     *
     * Nota: la scalatura automatica alla creazione di una TimeEntry viene
     * implementata nello STEP 12 — qui i dati sono pre-calcolati per coerenza.
     */
    public function run(): void
    {
        $acme = Company::where('vat_number', 'IT01234567890')->first();
        $beta = Company::where('vat_number', 'IT09876543210')->first();

        $pianoPro  = Plan::where('name', 'Piano Pro')->first();
        $pianoBase = Plan::where('name', 'Piano Base')->first();

        $today = Carbon::today();

        // ── Acme Srl — Piano Pro, subscription attiva ─────────────────────────
        Subscription::firstOrCreate(
            ['company_id' => $acme->id, 'plan_id' => $pianoPro->id],
            [
                'minutes_remaining' => 1740, // 2000 - 260 spesi (ticket 2 + ticket 3)
                'starts_at'         => $today->copy()->subDays(10),
                'expires_at'        => $today->copy()->addDays(20),
            ]
        );

        // ── Beta SpA — Piano Base, subscription con minuti quasi esauriti ─────
        // Simula un cliente che ha consumato quasi tutto il piano (warning < 20%)
        Subscription::firstOrCreate(
            ['company_id' => $beta->id, 'plan_id' => $pianoBase->id],
            [
                'minutes_remaining' => 85, // 500 - 35 spesi (ticket 4 + ticket 5) + scenario warning (< 20% = 100 min)
                'starts_at'         => $today->copy()->subDays(25),
                'expires_at'        => $today->copy()->addDays(5),
            ]
        );
    }
}
