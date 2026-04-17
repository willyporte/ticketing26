<?php

use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\TicketReply;
use App\Models\User;

test('totalMinutesSpent somma tutte le time entry del ticket', function () {
    $ticket = Ticket::factory()->create();
    TimeEntry::factory()->create(['ticket_id' => $ticket->id, 'minutes_spent' => 30]);
    TimeEntry::factory()->create(['ticket_id' => $ticket->id, 'minutes_spent' => 45]);

    expect($ticket->totalMinutesSpent())->toBe(75);
});

test('totalMinutesSpent è 0 se non ci sono time entry', function () {
    $ticket = Ticket::factory()->create();

    expect($ticket->totalMinutesSpent())->toBe(0);
});

test('le reply sono ordinate in modo ascendente per data', function () {
    $ticket = Ticket::factory()->create();

    $reply2 = TicketReply::factory()->create([
        'ticket_id'  => $ticket->id,
        'created_at' => now()->addMinutes(10),
    ]);
    $reply1 = TicketReply::factory()->create([
        'ticket_id'  => $ticket->id,
        'created_at' => now(),
    ]);

    $replies = $ticket->replies;

    expect($replies->first()->id)->toBe($reply1->id);
    expect($replies->last()->id)->toBe($reply2->id);
});

test('soft delete del ticket non elimina le reply', function () {
    $ticket = Ticket::factory()->create();
    TicketReply::factory()->count(2)->create(['ticket_id' => $ticket->id]);

    $ticket->delete();

    expect(TicketReply::where('ticket_id', $ticket->id)->count())->toBe(2);
});

test('il ticket è castato con gli enum corretti', function () {
    $ticket = Ticket::factory()->create();

    expect($ticket->status)->toBeInstanceOf(\App\Enums\TicketStatus::class);
    expect($ticket->priority)->toBeInstanceOf(\App\Enums\TicketPriority::class);
});
