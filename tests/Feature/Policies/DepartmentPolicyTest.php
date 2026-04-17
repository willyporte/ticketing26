<?php

use App\Models\Department;
use App\Models\User;
use App\Policies\DepartmentPolicy;

$policy = fn () => new DepartmentPolicy;

test('viewAny e view: administrator e supervisor', function () use ($policy) {
    $admin  = User::factory()->administrator()->create();
    $sup    = User::factory()->supervisor()->create();
    $op     = User::factory()->operator()->create();
    $dept   = Department::factory()->create();

    expect($policy()->viewAny($admin))->toBeTrue();
    expect($policy()->viewAny($sup))->toBeTrue();
    expect($policy()->viewAny($op))->toBeFalse();
    expect($policy()->view($admin, $dept))->toBeTrue();
    expect($policy()->view($sup, $dept))->toBeTrue();
    expect($policy()->view($op, $dept))->toBeFalse();
});

test('create, update, delete, restore: solo administrator', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $sup   = User::factory()->supervisor()->create();
    $dept  = Department::factory()->create();

    expect($policy()->create($admin))->toBeTrue();
    expect($policy()->create($sup))->toBeFalse();
    expect($policy()->update($admin, $dept))->toBeTrue();
    expect($policy()->update($sup, $dept))->toBeFalse();
    expect($policy()->delete($admin, $dept))->toBeTrue();
    expect($policy()->delete($sup, $dept))->toBeFalse();
    expect($policy()->restore($admin, $dept))->toBeTrue();
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin = User::factory()->administrator()->create();
    $dept  = Department::factory()->create();

    expect($policy()->forceDelete($admin, $dept))->toBeFalse();
});
