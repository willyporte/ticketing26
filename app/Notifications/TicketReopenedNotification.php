<?php

namespace App\Notifications;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Notifications\Notification;

class TicketReopenedNotification extends Notification
{
    public function __construct(
        private readonly Ticket $ticket,
        private readonly User   $author,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
        // TODO: decommentare in produzione
        // return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => __('notifications.ticket_reopened.title'),
            'body'    => __('notifications.ticket_reopened.body', [
                'title'  => $this->ticket->title,
                'author' => $this->author->name,
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
