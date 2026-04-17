<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Plan> */
class PlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => fake()->words(2, true) . ' Plan',
            'total_minutes' => fake()->numberBetween(120, 1200),
            'validity_days' => 30,
            'price'         => fake()->randomFloat(2, 49, 499),
        ];
    }
}
