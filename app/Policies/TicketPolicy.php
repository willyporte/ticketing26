<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Visibilità lista ticket.
     * Client: sempre true — il filtro sui propri/azienda viene applicato nella query (STEP 11).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Visibilità singolo ticket.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor() || $user->isOperator()) {
            return true;
        }

        // Client: vede i ticket della propria company
        if ($user->isClient()) {
            if ($user->company_id !== $ticket->company_id) {
                return false;
            }
            // can_view_company_tickets = true → tutti i ticket dell'azienda
            // can_view_company_tickets = false → solo i propri
            return $user->can_view_company_tickets || $ticket->created_by === $user->id;
        }

        return false;
    }

    /**
     * Creazione ticket.
     * Client: bloccato se nessuna subscription attiva o minuti ≤ 0.
     */
    public function create(User $user): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor() || $user->isOperator()) {
            return true;
        }

        if ($user->isClient()) {
            $subscription = $user->company?->activeSubscription();

            if (! $subscription) {
                return false; // nessuna subscription attiva
            }

            return $subscription->minutes_remaining > 0;
        }

        return false;
    }

    /**
     * Modifica ticket (titolo, descrizione, priorità, reparto).
     * Client non può modificare i campi del ticket.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    /**
     * Assegnazione ticket a un operatore.
     * Operator: può assegnare solo a sé stesso (vincolo enforced nel form in STEP 11).
     */
    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    /**
     * Chiusura ticket.
     */
    public function close(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    /**
     * Riapertura ticket.
     */
    public function reopen(User $user, Ticket $ticket): bool
    {
        return true; // tutti i ruoli possono riaprire
    }

    /**
     * Aggiunta di una reply al ticket (chi può vedere può rispondere).
     */
    public function createReply(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Aggiunta di un allegato al ticket o a una sua reply.
     */
    public function createAttachment(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Download allegato — un Client non può scaricare allegati di altri ticket.
     */
    public function downloadAttachment(User $user, Ticket $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Inserimento time entry — solo staff interno.
     */
    public function createTimeEntry(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator() || $user->isSupervisor() || $user->isOperator();
    }

    /**
     * Eliminazione (soft delete) — solo Administrator.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Ticket $ticket): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false; // mai nell'MVP
    }
}
