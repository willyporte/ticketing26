<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low    = 'low';
    case Medium = 'medium';
    case High   = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match($this) {
            self::Low    => __('tickets.priority.low'),
            self::Medium => __('tickets.priority.medium'),
            self::High   => __('tickets.priority.high'),
            self::Urgent => __('tickets.priority.urgent'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Low    => 'gray',
            self::Medium => 'info',
            self::High   => 'warning',
            self::Urgent => 'danger',
        };
    }
}
