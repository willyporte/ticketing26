<?php

namespace App\Observers;

use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\User;
use App\Notifications\SubscriptionLowMinutesNotification;
use App\Enums\UserRole;

class TimeEntryObserver
{
    /**
     * Quando una TimeEntry viene creata: scala i minuti dalla subscription attiva.
     */
    public function created(TimeEntry $timeEntry): void
    {
        $this->adjustMinutes($timeEntry->ticket, -$timeEntry->minutes_spent);
    }

    /**
     * Quando i minuti vengono modificati: aggiusta la differenza.
     */
    public function updated(TimeEntry $timeEntry): void
    {
        if ($timeEntry->wasChanged('minutes_spent')) {
            $delta = $timeEntry->getOriginal('minutes_spent') - $timeEntry->minutes_spent;
            $this->adjustMinutes($timeEntry->ticket, $delta);
        }
    }

    /**
     * Quando una TimeEntry viene eliminata (soft delete): restituisce i minuti.
     */
    public function deleted(TimeEntry $timeEntry): void
    {
        $this->adjustMinutes($timeEntry->ticket, $timeEntry->minutes_spent);
    }

    /**
     * Aggiusta i minuti residui della subscription attiva dell'azienda.
     *
     * $delta positivo  → aggiunge minuti (es. eliminazione time entry)
     * $delta negativo  → scala minuti   (es. creazione time entry)
     *
     * I minuti possono diventare negativi (lavoro extra non coperto — gestione commerciale).
     */
    private function adjustMinutes(?Ticket $ticket, int $delta): void
    {
        if (! $ticket) {
            return;
        }

        $subscription = $ticket->company?->activeSubscription();

        if (! $subscription) {
            return;
        }

        $subscription->increment('minutes_remaining', $delta);

        // Notifica DB all'Administrator se i minuti scendono sotto il 20%
        if ($delta < 0) {
            $subscription->refresh();

            if ($subscription->isBelowWarningThreshold()) {
                $notification = new SubscriptionLowMinutesNotification($subscription);

                User::where('role', UserRole::Administrator->value)
                    ->each(fn (User $admin) => $admin->notify($notification));
            }
        }
    }
}
