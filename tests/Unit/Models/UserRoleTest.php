<?php

use App\Models\User;

test('isAdministrator ritorna true solo per il ruolo administrator', function () {
    $user = new User(['role' => 'administrator']);

    expect($user->isAdministrator())->toBeTrue();
    expect($user->isSupervisor())->toBeFalse();
    expect($user->isOperator())->toBeFalse();
    expect($user->isClient())->toBeFalse();
});

test('isSupervisor ritorna true solo per il ruolo supervisor', function () {
    $user = new User(['role' => 'supervisor']);

    expect($user->isAdministrator())->toBeFalse();
    expect($user->isSupervisor())->toBeTrue();
    expect($user->isOperator())->toBeFalse();
    expect($user->isClient())->toBeFalse();
});

test('isOperator ritorna true solo per il ruolo operator', function () {
    $user = new User(['role' => 'operator']);

    expect($user->isAdministrator())->toBeFalse();
    expect($user->isSupervisor())->toBeFalse();
    expect($user->isOperator())->toBeTrue();
    expect($user->isClient())->toBeFalse();
});

test('isClient ritorna true solo per il ruolo client', function () {
    $user = new User(['role' => 'client']);

    expect($user->isAdministrator())->toBeFalse();
    expect($user->isSupervisor())->toBeFalse();
    expect($user->isOperator())->toBeFalse();
    expect($user->isClient())->toBeTrue();
});
