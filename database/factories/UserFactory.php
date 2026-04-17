<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(['email_verified_at' => null]);
    }

    public function administrator(): static
    {
        return $this->state(['role' => 'administrator', 'company_id' => null]);
    }

    public function supervisor(): static
    {
        return $this->state(['role' => 'supervisor']);
    }

    public function operator(): static
    {
        return $this->state(['role' => 'operator']);
    }

    public function client(): static
    {
        return $this->state(['role' => 'client']);
    }
}
