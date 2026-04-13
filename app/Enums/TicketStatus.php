<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open          = 'open';
    case InProgress    = 'in_progress';
    case WaitingClient = 'waiting_client';
    case Resolved      = 'resolved';
    case Closed        = 'closed';

    public function label(): string
    {
        return match($this) {
            self::Open          => __('tickets.status.open'),
            self::InProgress    => __('tickets.status.in_progress'),
            self::WaitingClient => __('tickets.status.waiting_client'),
            self::Resolved      => __('tickets.status.resolved'),
            self::Closed        => __('tickets.status.closed'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Open          => 'info',
            self::InProgress    => 'warning',
            self::WaitingClient => 'gray',
            self::Resolved      => 'success',
            self::Closed        => 'danger',
        };
    }
}
