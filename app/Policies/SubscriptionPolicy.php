<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Solo Administrator gestisce gli abbonamenti.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->isAdministrator();
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Subscription $subscription): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Subscription $subscription): bool
    {
        return false;
    }
}
