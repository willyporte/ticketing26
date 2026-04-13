<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Seed reparti globali per smistamento ticket.
     * I Department sono condivisi tra tutte le aziende — non company-specific.
     */
    public function run(): void
    {
        $departments = [
            'Supporto',
            'Sviluppo',
            'Amministrazione',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }
    }
}
