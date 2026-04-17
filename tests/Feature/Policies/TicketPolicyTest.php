<?php

use App\Models\Company;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\TicketPolicy;

$policy = fn () => new TicketPolicy;

// ─── viewAny ──────────────────────────────────────────────────────────────────

test('viewAny è sempre true per tutti i ruoli', function () use ($policy) {
    foreach (['administrator', 'supervisor', 'operator', 'client'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->viewAny($user))->toBeTrue();
    }
});

// ─── view ─────────────────────────────────────────────────────────────────────

test('view: administrator, supervisor e operator vedono qualsiasi ticket', function () use ($policy) {
    $ticket = Ticket::factory()->create();

    foreach (['administrator', 'supervisor', 'operator'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->view($user, $ticket))->toBeTrue("$role dovrebbe vedere il ticket");
    }
});

test('view: client vede il proprio ticket', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);

    expect($policy()->view($client, $ticket))->toBeTrue();
});

test('view: client con can_view_company_tickets vede tutti i ticket della propria company', function () use ($policy) {
    $company  = Company::factory()->create();
    $client   = User::factory()->client()->create([
        'company_id'               => $company->id,
        'can_view_company_tickets' => true,
    ]);
    $otherClient = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket   = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $otherClient->id]);

    expect($policy()->view($client, $ticket))->toBeTrue();
});

test('view: client senza can_view_company_tickets non vede i ticket di altri utenti della company', function () use ($policy) {
    $company  = Company::factory()->create();
    $client   = User::factory()->client()->create([
        'company_id'               => $company->id,
        'can_view_company_tickets' => false,
    ]);
    $otherClient = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket   = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $otherClient->id]);

    expect($policy()->view($client, $ticket))->toBeFalse();
});

test('view: client non vede ticket di un\'altra company', function () use ($policy) {
    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    $client   = User::factory()->client()->create([
        'company_id'               => $company1->id,
        'can_view_company_tickets' => true,
    ]);
    $ticket = Ticket::factory()->create(['company_id' => $company2->id]);

    expect($policy()->view($client, $ticket))->toBeFalse();
});

// ─── create ───────────────────────────────────────────────────────────────────

test('create: administrator, supervisor e operator possono sempre creare ticket', function () use ($policy) {
    foreach (['administrator', 'supervisor', 'operator'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->create($user))->toBeTrue("$role dovrebbe poter creare ticket");
    }
});

test('create: client con subscription attiva e minuti disponibili può creare ticket', function () use ($policy) {
    $company = Company::factory()->create();
    Subscription::factory()->create(['company_id' => $company->id, 'minutes_remaining' => 60]);
    $client = User::factory()->client()->create(['company_id' => $company->id]);

    expect($policy()->create($client))->toBeTrue();
});

test('create: client bloccato se la subscription è esaurita (minuti = 0)', function () use ($policy) {
    $company = Company::factory()->create();
    Subscription::factory()->exhausted()->create(['company_id' => $company->id]);
    $client = User::factory()->client()->create(['company_id' => $company->id]);

    expect($policy()->create($client))->toBeFalse();
});

test('create: client bloccato se non ha subscription attiva', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);

    expect($policy()->create($client))->toBeFalse();
});

test('create: client bloccato se la subscription è scaduta', function () use ($policy) {
    $company = Company::factory()->create();
    Subscription::factory()->expired()->create(['company_id' => $company->id, 'minutes_remaining' => 600]);
    $client = User::factory()->client()->create(['company_id' => $company->id]);

    expect($policy()->create($client))->toBeFalse();
});

// ─── update ───────────────────────────────────────────────────────────────────

test('update: solo staff può modificare un ticket', function () use ($policy) {
    $ticket = Ticket::factory()->create();

    foreach (['administrator', 'supervisor', 'operator'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->update($user, $ticket))->toBeTrue();
    }
});

test('update: client non può modificare un ticket', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id]);

    expect($policy()->update($client, $ticket))->toBeFalse();
});

// ─── assign / close / createTimeEntry ─────────────────────────────────────────

test('assign e close: solo staff', function () use ($policy) {
    $ticket = Ticket::factory()->create();

    foreach (['administrator', 'supervisor', 'operator'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->assign($user, $ticket))->toBeTrue();
        expect($policy()->close($user, $ticket))->toBeTrue();
    }
});

test('assign e close: client non può', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id]);

    expect($policy()->assign($client, $ticket))->toBeFalse();
    expect($policy()->close($client, $ticket))->toBeFalse();
});

test('createTimeEntry: solo staff', function () use ($policy) {
    $ticket = Ticket::factory()->create();

    foreach (['administrator', 'supervisor', 'operator'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->createTimeEntry($user, $ticket))->toBeTrue();
    }
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    expect($policy()->createTimeEntry($client, $ticket))->toBeFalse();
});

// ─── reopen ───────────────────────────────────────────────────────────────────

test('reopen: tutti i ruoli possono riaprire', function () use ($policy) {
    $ticket = Ticket::factory()->create();

    foreach (['administrator', 'supervisor', 'operator', 'client'] as $role) {
        $user = User::factory()->create(['role' => $role]);
        expect($policy()->reopen($user, $ticket))->toBeTrue();
    }
});

// ─── createReply / createAttachment / downloadAttachment ──────────────────────

test('createReply delega a view', function () use ($policy) {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);

    expect($policy()->createReply($client, $ticket))->toBeTrue();
    expect($policy()->createAttachment($client, $ticket))->toBeTrue();
    expect($policy()->downloadAttachment($client, $ticket))->toBeTrue();
});

// ─── delete / forceDelete ─────────────────────────────────────────────────────

test('delete: solo administrator', function () use ($policy) {
    $ticket = Ticket::factory()->create();
    $admin  = User::factory()->administrator()->create();
    $sup    = User::factory()->supervisor()->create();

    expect($policy()->delete($admin, $ticket))->toBeTrue();
    expect($policy()->delete($sup, $ticket))->toBeFalse();
});

test('forceDelete: sempre false', function () use ($policy) {
    $ticket = Ticket::factory()->create();
    $admin  = User::factory()->administrator()->create();

    expect($policy()->forceDelete($admin, $ticket))->toBeFalse();
});
