<?php

use App\Models\Company;
use App\Models\User;
use App\Policies\CompanyPolicy;

$policy = fn () => new CompanyPolicy;

test('tutte le azioni sono riservate all\'administrator', function () use ($policy) {
    $admin   = User::factory()->administrator()->create();
    $sup     = User::factory()->supervisor()->create();
    $company = Company::factory()->create();

    expect($policy()->viewAny($admin))->toBeTrue();
    expect($policy()->view($admin, $company))->toBeTrue();
    expect($policy()->create($admin))->toBeTrue();
    expect($policy()->update($admin, $company))->toBeTrue();
    expect($policy()->delete($admin, $company))->toBeTrue();
    expect($policy()->restore($admin, $company))->toBeTrue();

    expect($policy()->viewAny($sup))->toBeFalse();
    expect($policy()->view($sup, $company))->toBeFalse();
    expect($policy()->create($sup))->toBeFalse();
});

test('forceDelete: sempre false', function () use ($policy) {
    $admin   = User::factory()->administrator()->create();
    $company = Company::factory()->create();

    expect($policy()->forceDelete($admin, $company))->toBeFalse();
});
