<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<TicketAttachment> */
class TicketAttachmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id'   => Ticket::factory(),
            'reply_id'    => null,
            'uploaded_by' => User::factory(),
            'filename'    => fake()->word() . '.pdf',
            'path'        => 'attachments/1/1/' . Str::uuid() . '.pdf',
            'mime_type'   => 'application/pdf',
            'size'        => fake()->numberBetween(10_000, 5_000_000),
        ];
    }
}
