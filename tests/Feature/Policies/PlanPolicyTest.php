<?php

use App\Models\Plan;
use App\Models\User;
use App\Policies\PlanPolicy;

$policy = fn () => new PlanPolicy;

test('tutte le azioni riservate all\'administrator', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $plan  = Plan::factory()->create();

    foreach (['viewAny', 'create'] as $method) {
        expect($policy()->$method($admin))->toBeTrue("$method dovrebbe essere true per admin");
        expect($policy()->$method($sup))->toBeFalse("$method dovrebbe essere false per supervisor");
    }

    foreach (['view', 'update', 'delete', 'restore'] as $method) {
        expect($policy()->$method($admin, $plan))->toBeTrue();
        expect($policy()->$method($sup, $plan))->toBeFalse();
    }
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $plan  = Plan::factory()->create();

    expect($policy()->forceDelete($admin, $plan))->toBeFalse();
});
