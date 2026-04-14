<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    /**
     * Intercetta il mount prima dell'autorizzazione:
     * se il Client non ha una subscription attiva con minuti > 0, mostra un
     * messaggio amichevole e reindirizza alla lista invece di un 403 generico.
     */
    public function mount(): void
    {
        $user = auth()->user();

        if ($user->isClient()) {
            $subscription = $user->company?->activeSubscription();

            if (! $subscription || $subscription->minutes_remaining <= 0) {
                Notification::make()
                    ->title(__('subscriptions.messages.client_blocked'))
                    ->danger()
                    ->persistent()
                    ->send();

                $this->redirect(TicketResource::getUrl('index'));

                return;
            }
        }

        parent::mount();
    }

    /**
     * Prima di salvare: imposta i campi gestiti server-side.
     * - created_by: sempre l'utente autenticato
     * - status: sempre 'open' alla creazione
     * - company_id: auto-impostato per il Client (il form lo nasconde)
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status']     = TicketStatus::Open->value;

        if (auth()->user()->isClient()) {
            $data['company_id'] = auth()->user()->company_id;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
