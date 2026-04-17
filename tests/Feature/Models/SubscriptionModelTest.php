<?php

use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;

test('scopeActive restituisce solo le subscription attive', function () {
    $company = Company::factory()->create();
    $plan    = Plan::factory()->create(['total_minutes' => 600]);

    $active  = Subscription::factory()->create(['company_id' => $company->id, 'plan_id' => $plan->id]);
    $expired = Subscription::factory()->expired()->create(['company_id' => $company->id, 'plan_id' => $plan->id]);

    $actives = Subscription::active()->get();

    expect($actives->contains($active))->toBeTrue();
    expect($actives->contains($expired))->toBeFalse();
});

test('isBelowWarningThreshold è true se i minuti sono sotto il 20% del totale', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 100]);

    expect($sub->isBelowWarningThreshold())->toBeTrue(); // 100/600 ≈ 16.7%
});

test('isBelowWarningThreshold è false se i minuti sono sopra il 20% del totale', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 200]);

    expect($sub->isBelowWarningThreshold())->toBeFalse(); // 200/600 ≈ 33%
});

test('isBelowWarningThreshold è false se il piano ha 0 minuti totali', function () {
    $plan = Plan::factory()->create(['total_minutes' => 0]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 0]);

    expect($sub->isBelowWarningThreshold())->toBeFalse();
});

test('remainingPercentage calcola correttamente la percentuale', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 300]);

    expect($sub->remainingPercentage())->toBe(50);
});

test('remainingPercentage è 0 se i minuti sono negativi', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => -100]);

    expect($sub->remainingPercentage())->toBe(0);
});

test('remainingPercentage non supera 100', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 700]);

    expect($sub->remainingPercentage())->toBe(100);
});

test('deductMinutes scala i minuti residui', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 600]);

    $sub->deductMinutes(60);

    expect($sub->fresh()->minutes_remaining)->toBe(540);
});

test('deductMinutes può portare i minuti in negativo', function () {
    $plan = Plan::factory()->create(['total_minutes' => 600]);
    $sub  = Subscription::factory()->create(['plan_id' => $plan->id, 'minutes_remaining' => 30]);

    $sub->deductMinutes(60);

    expect($sub->fresh()->minutes_remaining)->toBe(-30);
});

test('Company::activeSubscription restituisce la subscription attiva', function () {
    $company = Company::factory()->create();
    $plan    = Plan::factory()->create();

    $active  = Subscription::factory()->create(['company_id' => $company->id, 'plan_id' => $plan->id]);
    Subscription::factory()->expired()->create(['company_id' => $company->id, 'plan_id' => $plan->id]);

    expect($company->activeSubscription()?->id)->toBe($active->id);
});

test('Company::activeSubscription restituisce null se non c\'è subscription attiva', function () {
    $company = Company::factory()->create();
    Plan::factory()->create();

    expect($company->activeSubscription())->toBeNull();
});
