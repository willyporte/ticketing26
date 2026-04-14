<?php

namespace App\Notifications;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketCreatedNotification extends Notification
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
            'title'   => __('notifications.ticket_created.title'),
            'body'    => __('notifications.ticket_created.body', [
                'title'   => $this->ticket->title,
                'creator' => $this->ticket->creator?->name ?? '-',
                'company' => $this->ticket->company?->name ?? '-',
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->subject(__('notifications.ticket_created.subject', ['title' => $this->ticket->title]))
    //         ->line(__('notifications.ticket_created.body', [...]))
    //         ->action(__('notifications.actions.view_ticket'), TicketResource::getUrl('view', ['record' => $this->ticket]));
    // }
}
