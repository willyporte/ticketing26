<?php

namespace App\Notifications;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification
{
    public function __construct(private readonly Ticket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
        // TODO: decommentare in produzione
        // return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => __('notifications.ticket_assigned.title'),
            'body'    => __('notifications.ticket_assigned.body', [
                'title' => $this->ticket->title,
            ]),
            'actions' => [
                [
                    'name'  => 'view',
                    'label' => __('notifications.actions.view_ticket'),
                    'url'   => TicketResource::getUrl('view', ['record' => $this->ticket]),
                ],
            ],
        ];
    }

    // TODO: decommentare in produzione
    // public function toMail(object $notifiable): MailMessage { ... }
}
