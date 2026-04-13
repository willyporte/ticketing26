<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Solo Administrator gestisce le aziende.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function view(User $user, Company $company): bool
    {
        return $user->isAdministrator();
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Company $company): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return false; // mai nell'MVP
    }
}
