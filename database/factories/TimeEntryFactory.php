<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TimeEntry> */
class TimeEntryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id'     => Ticket::factory(),
            'user_id'       => User::factory(),
            'minutes_spent' => fake()->numberBetween(15, 120),
            'notes'         => fake()->optional()->sentence(),
        ];
    }
}
