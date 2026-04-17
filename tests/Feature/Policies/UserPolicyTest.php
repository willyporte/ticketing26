<?php

use App\Models\User;
use App\Policies\UserPolicy;

$policy = fn () => new UserPolicy;

test('viewAny: administrator e supervisor possono vedere la lista utenti', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();

    expect($policy()->viewAny($admin))->toBeTrue();
    expect($policy()->viewAny($sup))->toBeTrue();
});

test('viewAny: operator e client non possono vedere la lista utenti', function () use ($policy) {
    $operator = User::factory()->operator()->create();
    $client   = User::factory()->client()->create();

    expect($policy()->viewAny($operator))->toBeFalse();
    expect($policy()->viewAny($client))->toBeFalse();
});

test('view: ognuno può vedere sé stesso', function () use ($policy) {
    $user = User::factory()->operator()->create();

    expect($policy()->view($user, $user))->toBeTrue();
});

test('view: administrator e supervisor vedono qualsiasi utente', function () use ($policy) {
    $admin  = User::factory()->administrator()->create();
    $target = User::factory()->client()->create();

    expect($policy()->view($admin, $target))->toBeTrue();
});

test('view: operator non può vedere altri utenti', function () use ($policy) {
    $operator = User::factory()->operator()->create();
    $other    = User::factory()->client()->create();

    expect($policy()->view($operator, $other))->toBeFalse();
});

test('create e update: solo administrator', function () use ($policy) {
    $admin  = User::factory()->administrator()->create();
    $sup    = User::factory()->supervisor()->create();
    $target = User::factory()->client()->create();

    expect($policy()->create($admin))->toBeTrue();
    expect($policy()->create($sup))->toBeFalse();
    expect($policy()->update($admin, $target))->toBeTrue();
    expect($policy()->update($sup, $target))->toBeFalse();
});

test('delete: administrator non può cancellare sé stesso', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $other = User::factory()->client()->create();

    expect($policy()->delete($admin, $admin))->toBeFalse();
    expect($policy()->delete($admin, $other))->toBeTrue();
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin  = User::factory()->administrator()->create();
    $target = User::factory()->client()->create();

    expect($policy()->forceDelete($admin, $target))->toBeFalse();
});
