<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Ticket> */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'         => fake()->sentence(6),
            'description'   => fake()->paragraph(),
            'status'        => TicketStatus::Open,
            'priority'      => TicketPriority::Medium,
            'company_id'    => Company::factory(),
            'department_id' => null,
            'created_by'    => User::factory(),
            'assigned_to'   => null,
        ];
    }

    public function open(): static
    {
        return $this->state(['status' => TicketStatus::Open]);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => TicketStatus::InProgress]);
    }

    public function resolved(): static
    {
        return $this->state(['status' => TicketStatus::Resolved]);
    }

    public function closed(): static
    {
        return $this->state(['status' => TicketStatus::Closed]);
    }
}
