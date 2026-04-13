<?php

namespace App\Policies;

use App\Models\TimeEntry;
use App\Models\User;

class TimeEntryPolicy
{
    /**
     * Administrator, Supervisor e Operator vedono le time entry.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    public function view(User $user, TimeEntry $timeEntry): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor()) {
            return true;
        }

        // Operator vede solo le proprie time entry
        if ($user->isOperator()) {
            return $timeEntry->user_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    public function update(User $user, TimeEntry $timeEntry): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor()) {
            return true;
        }

        // Operator può modificare solo le proprie time entry
        if ($user->isOperator()) {
            return $timeEntry->user_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, TimeEntry $timeEntry): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor()) {
            return true;
        }

        if ($user->isOperator()) {
            return $timeEntry->user_id === $user->id;
        }

        return false;
    }

    public function restore(User $user, TimeEntry $timeEntry): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, TimeEntry $timeEntry): bool
    {
        return false;
    }
}
