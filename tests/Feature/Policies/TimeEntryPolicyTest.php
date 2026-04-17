<?php

use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\User;
use App\Policies\TimeEntryPolicy;

$policy = fn () => new TimeEntryPolicy;

test('viewAny: administrator, supervisor e operator; client no', function () use ($policy) {
    $admin    = User::factory()->administrator()->create();
    $sup      = User::factory()->supervisor()->create();
    $op       = User::factory()->operator()->create();
    $client   = User::factory()->client()->create();

    expect($policy()->viewAny($admin))->toBeTrue();
    expect($policy()->viewAny($sup))->toBeTrue();
    expect($policy()->viewAny($op))->toBeTrue();
    expect($policy()->viewAny($client))->toBeFalse();
});

test('view: administrator e supervisor vedono tutte le entry', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $entry = TimeEntry::factory()->create();

    expect($policy()->view($admin, $entry))->toBeTrue();
    expect($policy()->view($sup, $entry))->toBeTrue();
});

test('view: operator vede solo le proprie time entry', function () use ($policy) {
    $op1   = User::factory()->operator()->create();
    $op2   = User::factory()->operator()->create();
    $entry = TimeEntry::factory()->create(['user_id' => $op1->id]);

    expect($policy()->view($op1, $entry))->toBeTrue();
    expect($policy()->view($op2, $entry))->toBeFalse();
});

test('view: client non vede time entry', function () use ($policy) {
    $client = User::factory()->client()->create();
    $entry  = TimeEntry::factory()->create();

    expect($policy()->view($client, $entry))->toBeFalse();
});

test('create: staff può creare; client no', function () use ($policy) {
    $admin  = User::factory()->administrator()->create();
    $op     = User::factory()->operator()->create();
    $client = User::factory()->client()->create();

    expect($policy()->create($admin))->toBeTrue();
    expect($policy()->create($op))->toBeTrue();
    expect($policy()->create($client))->toBeFalse();
});

test('update e delete: operator può agire solo sulle proprie entry', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $op1   = User::factory()->operator()->create();
    $op2   = User::factory()->operator()->create();
    $entry = TimeEntry::factory()->create(['user_id' => $op1->id]);

    expect($policy()->update($admin, $entry))->toBeTrue();
    expect($policy()->update($op1, $entry))->toBeTrue();
    expect($policy()->update($op2, $entry))->toBeFalse();
    expect($policy()->delete($op1, $entry))->toBeTrue();
    expect($policy()->delete($op2, $entry))->toBeFalse();
});

test('restore: solo administrator', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $entry = TimeEntry::factory()->create();

    expect($policy()->restore($admin, $entry))->toBeTrue();
    expect($policy()->restore($sup, $entry))->toBeFalse();
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $entry = TimeEntry::factory()->create();

    expect($policy()->forceDelete($admin, $entry))->toBeFalse();
});
