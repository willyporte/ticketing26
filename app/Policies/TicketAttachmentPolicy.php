<?php

namespace App\Policies;

use App\Models\TicketAttachment;
use App\Models\User;

class TicketAttachmentPolicy
{
    /**
     * TicketAttachment non ha voce nel menu — si gestisce dentro la pagina del Ticket.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TicketAttachment $attachment): bool
    {
        // Risolve il ticket padre sia da allegato diretto che da reply
        $ticket = $attachment->ticket ?? $attachment->reply?->ticket;

        if (! $ticket) {
            return false;
        }

        return $user->can('downloadAttachment', $ticket);
    }

    public function create(User $user): bool
    {
        return true; // il controllo specifico è in TicketPolicy::createAttachment
    }

    public function delete(User $user, TicketAttachment $attachment): bool
    {
        if ($user->isAdministrator() || $user->isSupervisor()) {
            return true;
        }

        // Ognuno può eliminare solo i propri allegati
        return $attachment->uploaded_by === $user->id;
    }

    public function restore(User $user, TicketAttachment $attachment): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, TicketAttachment $attachment): bool
    {
        return false;
    }
}
