<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'          => 'Piano Base',
                'total_minutes' => 500,
                'validity_days' => 30,
                'price'         => 49.00,
            ],
            [
                'name'          => 'Piano Pro',
                'total_minutes' => 2000,
                'validity_days' => 30,
                'price'         => 149.00,
            ],
            [
                'name'          => 'Piano Enterprise',
                'total_minutes' => 5000,
                'validity_days' => 30,
                'price'         => 299.00,
            ],
        ];

        foreach ($plans as $data) {
            Plan::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
