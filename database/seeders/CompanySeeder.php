<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Seed aziende demo e assegna gli utenti già creati in UserSeeder.
     */
    public function run(): void
    {
        // ── Azienda 1: Acme Srl ───────────────────────────────────────────────
        $acme = Company::firstOrCreate(
            ['vat_number' => 'IT01234567890'],
            [
                'name'      => 'Acme Srl',
                'email'     => 'info@acme.example.it',
                'phone'     => '02 1234567',
                'logo_path' => null,
            ]
        );

        // ── Azienda 2: Beta SpA ───────────────────────────────────────────────
        $beta = Company::firstOrCreate(
            ['vat_number' => 'IT09876543210'],
            [
                'name'      => 'Beta SpA',
                'email'     => 'info@beta.example.it',
                'phone'     => '06 9876543',
                'logo_path' => null,
            ]
        );

        // ── Assegnazione utenti alle aziende ──────────────────────────────────
        // Supervisor → Acme
        User::where('email', 'supervisore@demo.com')
            ->update(['company_id' => $acme->id]);

        // Operatore 1 → Acme
        User::where('email', 'operatore1@demo.com')
            ->update(['company_id' => $acme->id]);

        // Operatore 2 → Beta
        User::where('email', 'operatore2@demo.com')
            ->update(['company_id' => $beta->id]);

        // Clienti: 2 su Acme, 1 su Beta
        User::where('email', 'cliente1@demo.com')
            ->update(['company_id' => $acme->id]);

        User::where('email', 'cliente2@demo.com')
            ->update(['company_id' => $acme->id]);

        User::where('email', 'cliente3@demo.com')
            ->update(['company_id' => $beta->id]);
    }
}
