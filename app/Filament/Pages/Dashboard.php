<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Actions\Action;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        // Il bottone è visibile solo agli utenti che possono creare ticket.
        // La Policy (TicketPolicy::create) blocca già i Client senza subscription attiva.
        if (! auth()->user()?->can('create', Ticket::class)) {
            return [];
        }

        return [
            Action::make('createTicket')
                ->label(__('tickets.actions.create'))
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->url(TicketResource::getUrl('create')),
        ];
    }
}
