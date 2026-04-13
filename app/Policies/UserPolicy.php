<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Solo Administrator e Supervisor vedono la lista utenti.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator() || $user->isSupervisor();
    }

    public function view(User $user, User $model): bool
    {
        // Ognuno può vedere il proprio profilo
        if ($user->id === $model->id) {
            return true;
        }

        return $user->isAdministrator() || $user->isSupervisor();
    }

    /**
     * Solo Administrator può creare utenti.
     */
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Solo Administrator può modificare utenti.
     * Tutti possono modificare il proprio profilo (gestito dalla pagina profilo Filament).
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, User $model): bool
    {
        // Non si può eliminare sé stessi
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdministrator();
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false; // mai nell'MVP
    }
}
