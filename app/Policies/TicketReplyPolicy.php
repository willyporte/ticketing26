<?php

namespace App\Policies;

use App\Models\TicketReply;
use App\Models\User;

class TicketReplyPolicy
{
    /**
     * TicketReply non ha voce nel menu — si gestisce dentro la pagina del Ticket.
     * Le autorizzazioni si basano sulla visibilità del ticket padre.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TicketReply $reply): bool
    {
        // Delega alla TicketPolicy via il ticket padre
        return $user->can('view', $reply->ticket);
    }

    public function create(User $user): bool
    {
        return true; // il controllo specifico è in TicketPolicy::createReply
    }

    public function update(User $user, TicketReply $reply): bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        // Ognuno può modificare solo le proprie reply
        return $reply->user_id === $user->id;
    }

    public function delete(User $user, TicketReply $reply): bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return $reply->user_id === $user->id;
    }

    public function restore(User $user, TicketReply $reply): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, TicketReply $reply): bool
    {
        return false;
    }
}
