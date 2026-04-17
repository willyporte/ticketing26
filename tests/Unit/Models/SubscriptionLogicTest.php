<?php

use App\Models\Subscription;

test('isActive ritorna true se la data odierna è compresa tra starts_at e expires_at', function () {
    $sub = new Subscription([
        'starts_at'  => now()->subDay()->toDateString(),
        'expires_at' => now()->addDay()->toDateString(),
    ]);

    expect($sub->isActive())->toBeTrue();
});

test('isActive ritorna false se expires_at è nel passato', function () {
    $sub = new Subscription([
        'starts_at'  => now()->subDays(10)->toDateString(),
        'expires_at' => now()->subDay()->toDateString(),
    ]);

    expect($sub->isActive())->toBeFalse();
});

test('isActive ritorna false se starts_at è nel futuro', function () {
    $sub = new Subscription([
        'starts_at'  => now()->addDay()->toDateString(),
        'expires_at' => now()->addDays(30)->toDateString(),
    ]);

    expect($sub->isActive())->toBeFalse();
});

test('isActive ritorna true se la data odierna coincide con starts_at', function () {
    $sub = new Subscription([
        'starts_at'  => now()->toDateString(),
        'expires_at' => now()->addDays(30)->toDateString(),
    ]);

    expect($sub->isActive())->toBeTrue();
});

test('isActive ritorna true se la data odierna coincide con expires_at', function () {
    $sub = new Subscription([
        'starts_at'  => now()->subDays(30)->toDateString(),
        'expires_at' => now()->toDateString(),
    ]);

    expect($sub->isActive())->toBeTrue();
});
