<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed utenti demo.
     * Nota: company_id è null in questo step — verrà popolato nello STEP 2 (CompanySeeder).
     * La password è sempre 'password' per tutti gli utenti demo.
     */
    public function run(): void
    {
        // ── Administrator di sistema ───────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name'                     => 'Mario Rossi',
                'password'                 => Hash::make('password'),
                'role'                     => 'administrator',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );

        // ── Supervisor (company assegnata nello STEP 2) ────────────────────────
        User::firstOrCreate(
            ['email' => 'supervisore@demo.com'],
            [
                'name'                     => 'Giulia Bianchi',
                'password'                 => Hash::make('password'),
                'role'                     => 'supervisor',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );

        // ── Operatori ──────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'operatore1@demo.com'],
            [
                'name'                     => 'Luca Verdi',
                'password'                 => Hash::make('password'),
                'role'                     => 'operator',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );

        User::firstOrCreate(
            ['email' => 'operatore2@demo.com'],
            [
                'name'                     => 'Sara Neri',
                'password'                 => Hash::make('password'),
                'role'                     => 'operator',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );

        // ── Client (company assegnata nello STEP 2) ────────────────────────────
        User::firstOrCreate(
            ['email' => 'cliente1@demo.com'],
            [
                'name'                     => 'Filippo Ferrari',
                'password'                 => Hash::make('password'),
                'role'                     => 'client',
                'company_id'               => null,
                'can_view_company_tickets' => true, // vede tutti i ticket dell'azienda
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente2@demo.com'],
            [
                'name'                     => 'Alessia Conti',
                'password'                 => Hash::make('password'),
                'role'                     => 'client',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente3@demo.com'],
            [
                'name'                     => 'Roberto Marini',
                'password'                 => Hash::make('password'),
                'role'                     => 'client',
                'company_id'               => null,
                'can_view_company_tickets' => false,
            ]
        );
    }
}
