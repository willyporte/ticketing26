<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * L'ordine è importante: rispetta le dipendenze tra tabelle.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,    // STEP 2
            DepartmentSeeder::class, // STEP 3
            TicketSeeder::class,      // STEP 4
            TicketReplySeeder::class,      // STEP 5
            TicketAttachmentSeeder::class, // STEP 6
            TimeEntrySeeder::class,    // STEP 7
            PlanSeeder::class,         // STEP 8
            SubscriptionSeeder::class, // STEP 8
        ]);
    }
}
