<?php

namespace App\Observers;

use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketReopenedNotification;
use App\Notifications\TicketResolvedNotification;
use Illuminate\Support\Collection;

class TicketObserver
{
    /**
     * Ticket appena creato: notifica supervisors e operatore assegnato (se presente).
     */
    public function created(Ticket $ticket): void
    {
        $ticket->loadMissing(['creator', 'assignee', 'company']);

        $recipients = User::where('role', UserRole::Supervisor->value)->get();

        if ($ticket->assignee) {
            $recipients->push($ticket->assignee);
        }

        $this->notify(
            $recipients->unique('id'),
            new TicketCreatedNotification($ticket),
            excludeId: $ticket->created_by,
        );
    }

    /**
     * Ticket modificato: gestisce assegnazione e transizioni di stato.
     */
    public function updated(Ticket $ticket): void
    {
        $ticket->loadMissing(['creator', 'assignee', 'company']);

        // ── Nuovo operatore assegnato ──────────────────────────────────────────
        if ($ticket->wasChanged('assigned_to') && $ticket->assigned_to) {
            $assignee = $ticket->assignee;

            if ($assignee) {
                $assignee->notify(new TicketAssignedNotification($ticket));
            }
        }

        // ── Ticket risolto → notifica al cliente creatore ─────────────────────
        if ($ticket->wasChanged('status') && $ticket->status === TicketStatus::Resolved) {
            $creator = $ticket->creator;

            if ($creator && $creator->isClient()) {
                $creator->notify(new TicketResolvedNotification($ticket));
            }
        }

        // ── Ticket riaperto → notifica ai supervisors ─────────────────────────
        if ($ticket->wasChanged('status') && $ticket->status === TicketStatus::Open) {
            $previousStatus = $ticket->getOriginal('status');

            $wasClosedOrResolved = in_array($previousStatus, [
                TicketStatus::Resolved->value,
                TicketStatus::Closed->value,
            ]);

            if ($wasClosedOrResolved) {
                $author = auth()->user();

                $supervisors = User::where('role', UserRole::Supervisor->value)->get();

                $this->notify(
                    $supervisors,
                    new TicketReopenedNotification($ticket, $author),
                    excludeId: $author?->id,
                );
            }
        }
    }

    /**
     * Invia una notifica a una collection di utenti, escludendo facoltativamente un ID.
     */
    private function notify(Collection $users, mixed $notification, ?int $excludeId = null): void
    {
        foreach ($users as $user) {
            if ($excludeId && $user->id === $excludeId) {
                continue;
            }

            $user->notify($notification);
        }
    }
}
