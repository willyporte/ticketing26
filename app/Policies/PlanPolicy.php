<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;

class PlanPolicy
{
    /**
     * Solo Administrator gestisce i piani.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function view(User $user, Plan $plan): bool
    {
        return $user->isAdministrator();
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Plan $plan): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, Plan $plan): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Plan $plan): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Plan $plan): bool
    {
        return false;
    }
}
