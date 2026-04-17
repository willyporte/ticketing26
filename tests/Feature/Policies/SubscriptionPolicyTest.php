<?php

use App\Models\Subscription;
use App\Models\User;
use App\Policies\SubscriptionPolicy;

$policy = fn () => new SubscriptionPolicy;

test('tutte le azioni riservate all\'administrator', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $sub   = Subscription::factory()->create();

    foreach (['viewAny', 'create'] as $method) {
        expect($policy()->$method($admin))->toBeTrue();
        expect($policy()->$method($sup))->toBeFalse();
    }

    foreach (['view', 'update', 'delete', 'restore'] as $method) {
        expect($policy()->$method($admin, $sub))->toBeTrue();
        expect($policy()->$method($sup, $sub))->toBeFalse();
    }
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sub   = Subscription::factory()->create();

    expect($policy()->forceDelete($admin, $sub))->toBeFalse();
});
