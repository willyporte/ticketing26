<?php

use App\Models\Company;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Policies\TicketReplyPolicy;

$policy = fn () => new TicketReplyPolicy;

test('viewAny: sempre true', function () use ($policy) {
    $user = User::factory()->client()->create();
    expect($policy()->viewAny($user))->toBeTrue();
});

test('create: sempre true (il controllo reale è in TicketPolicy)', function () use ($policy) {
    $user = User::factory()->client()->create();
    expect($policy()->create($user))->toBeTrue();
});

test('view: delega alla visibilità del ticket padre', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);
    $reply   = TicketReply::factory()->create(['ticket_id' => $ticket->id]);

    expect($policy()->view($client, $reply))->toBeTrue();
});

test('update: administrator può modificare qualsiasi reply', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $reply = TicketReply::factory()->create();

    expect($policy()->update($admin, $reply))->toBeTrue();
});

test('update: utente può modificare solo le proprie reply', function () use ($policy) {
    $op1   = User::factory()->operator()->create();
    $op2   = User::factory()->operator()->create();
    $reply = TicketReply::factory()->create(['user_id' => $op1->id]);

    expect($policy()->update($op1, $reply))->toBeTrue();
    expect($policy()->update($op2, $reply))->toBeFalse();
});

test('delete: administrator può cancellare qualsiasi reply', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $reply = TicketReply::factory()->create();

    expect($policy()->delete($admin, $reply))->toBeTrue();
});

test('delete: utente può cancellare solo le proprie reply', function () use ($policy) {
    $op1   = User::factory()->operator()->create();
    $op2   = User::factory()->operator()->create();
    $reply = TicketReply::factory()->create(['user_id' => $op1->id]);

    expect($policy()->delete($op1, $reply))->toBeTrue();
    expect($policy()->delete($op2, $reply))->toBeFalse();
});

test('restore: solo administrator', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $reply = TicketReply::factory()->create();

    expect($policy()->restore($admin, $reply))->toBeTrue();
    expect($policy()->restore($sup, $reply))->toBeFalse();
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $reply = TicketReply::factory()->create();

    expect($policy()->forceDelete($admin, $reply))->toBeFalse();
});
