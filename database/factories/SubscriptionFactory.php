<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Subscription> */
class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id'        => Company::factory(),
            'plan_id'           => Plan::factory(),
            'minutes_remaining' => 600,
            'starts_at'         => now()->subDay(),
            'expires_at'        => now()->addDays(30),
        ];
    }

    public function expired(): static
    {
        return $this->state([
            'starts_at'  => now()->subDays(60),
            'expires_at' => now()->subDay(),
        ]);
    }

    public function exhausted(): static
    {
        return $this->state(['minutes_remaining' => 0]);
    }
}
