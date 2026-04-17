<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Company> */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->company(),
            'vat_number' => 'IT' . fake()->numerify('###########'),
            'email'      => fake()->companyEmail(),
            'phone'      => fake()->phoneNumber(),
            'logo_path'  => null,
        ];
    }
}
