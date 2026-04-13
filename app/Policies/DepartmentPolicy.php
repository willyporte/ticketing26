<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    /**
     * Administrator e Supervisor vedono i reparti.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator() || $user->isSupervisor();
    }

    public function view(User $user, Department $department): bool
    {
        return $user->isAdministrator() || $user->isSupervisor();
    }

    /**
     * Solo Administrator crea e modifica reparti.
     */
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Department $department): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Department $department): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Department $department): bool
    {
        return false;
    }
}
