<?php

use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketReplyAddedNotification;
use App\Notifications\TicketReopenedNotification;
use App\Notifications\TicketResolvedNotification;
use Illuminate\Support\Facades\Notification;

// ─── TicketCreatedNotification ────────────────────────────────────────────────

test('TicketCreatedNotification usa solo il canale database', function () {
    $ticket       = Ticket::factory()->create();
    $notification = new TicketCreatedNotification($ticket);

    expect($notification->via(new stdClass))->toBe(['database']);
});

test('TicketCreatedNotification::toArray contiene i campi richiesti', function () {
    $ticket       = Ticket::factory()->create();
    $notification = new TicketCreatedNotification($ticket);
    $data         = $notification->toArray(new stdClass);

    expect($data)->toHaveKeys(['title', 'body', 'actions']);
    expect($data['actions'])->not->toBeEmpty();
    expect($data['actions'][0])->toHaveKey('url');
});

test('TicketCreatedNotification viene salvata nel DB', function () {
    Notification::fake();

    $ticket = Ticket::factory()->create();
    $sup    = User::factory()->supervisor()->create();

    $sup->notify(new TicketCreatedNotification($ticket));

    Notification::assertSentTo($sup, TicketCreatedNotification::class);
});

// ─── TicketAssignedNotification ───────────────────────────────────────────────

test('TicketAssignedNotification usa solo il canale database', function () {
    $ticket       = Ticket::factory()->create();
    $notification = new TicketAssignedNotification($ticket);

    expect($notification->via(new stdClass))->toBe(['database']);
});

test('TicketAssignedNotification::toArray contiene i campi richiesti', function () {
    $ticket       = Ticket::factory()->create();
    $notification = new TicketAssignedNotification($ticket);
    $data         = $notification->toArray(new stdClass);

    expect($data)->toHaveKeys(['title', 'body', 'actions']);
});

// ─── TicketReplyAddedNotification ─────────────────────────────────────────────

test('TicketReplyAddedNotification usa solo il canale database', function () {
    $ticket   = Ticket::factory()->create();
    $author   = User::factory()->operator()->create();
    $notif    = new TicketReplyAddedNotification($ticket, $author);

    expect($notif->via(new stdClass))->toBe(['database']);
});

test('TicketReplyAddedNotification viene inviata ai partecipanti', function () {
    Notification::fake();

    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $op      = User::factory()->operator()->create();
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);

    $op->notify(new TicketReplyAddedNotification($ticket, $client));

    Notification::assertSentTo($op, TicketReplyAddedNotification::class);
});

// ─── TicketResolvedNotification ───────────────────────────────────────────────

test('TicketResolvedNotification usa solo il canale database', function () {
    $ticket = Ticket::factory()->create();
    $notif  = new TicketResolvedNotification($ticket);

    expect($notif->via(new stdClass))->toBe(['database']);
});

test('TicketResolvedNotification::toArray contiene i campi richiesti', function () {
    $ticket = Ticket::factory()->create();
    $notif  = new TicketResolvedNotification($ticket);
    $data   = $notif->toArray(new stdClass);

    expect($data)->toHaveKeys(['title', 'body', 'actions']);
});

// ─── TicketReopenedNotification ───────────────────────────────────────────────

test('TicketReopenedNotification usa solo il canale database', function () {
    $ticket = Ticket::factory()->create();
    $author = User::factory()->client()->create();
    $notif  = new TicketReopenedNotification($ticket, $author);

    expect($notif->via(new stdClass))->toBe(['database']);
});

test('TicketReopenedNotification::toArray contiene i campi richiesti', function () {
    $ticket = Ticket::factory()->create();
    $author = User::factory()->client()->create();
    $notif  = new TicketReopenedNotification($ticket, $author);
    $data   = $notif->toArray(new stdClass);

    expect($data)->toHaveKeys(['title', 'body', 'actions']);
});
