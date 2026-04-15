<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\TicketAttachment;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    /** Percorsi UUID dei file caricati — salvati prima di passare a handleRecordCreation. */
    private array $pendingAttachmentPaths = [];

    /** Nomi originali dei file — keyed by UUID filename. */
    private array $pendingAttachmentNames = [];

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
     * Prima di salvare: imposta i campi gestiti server-side e
     * mette da parte i dati degli allegati (non appartengono al Ticket).
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Intercetta i dati degli allegati prima che arrivino a Ticket::create()
        $this->pendingAttachmentPaths = $data['attachment_paths'] ?? [];
        $this->pendingAttachmentNames = $data['attachment_names'] ?? [];

        unset($data['attachment_paths'], $data['attachment_names']);

        $data['created_by'] = auth()->id();
        $data['status']     = TicketStatus::Open->value;

        if (auth()->user()->isClient()) {
            $data['company_id'] = auth()->user()->company_id;
        }

        return $data;
    }

    /**
     * Dopo la creazione del ticket: sposta i file dalla cartella temp
     * al percorso definitivo e crea i record TicketAttachment.
     */
    protected function afterCreate(): void
    {
        $ticket = $this->record;
        $paths  = is_array($this->pendingAttachmentPaths) ? $this->pendingAttachmentPaths : [];
        $names  = is_array($this->pendingAttachmentNames) ? $this->pendingAttachmentNames : [];

        if (empty($paths)) {
            return;
        }

        $existing  = TicketAttachment::countForTicket($ticket->id);
        $directory = "attachments/{$ticket->company_id}/{$ticket->id}";

        Storage::disk('local')->makeDirectory($directory);

        foreach ($paths as $tempPath) {
            if ($existing >= 10) {
                break; // limite massimo 10 allegati per ticket
            }

            if (! Storage::disk('local')->exists($tempPath)) {
                continue;
            }

            $basename     = basename($tempPath);
            // storeFileNamesIn mappa: basename(UUID) → nome originale
            $originalName = $names[$tempPath] ?? $names[$basename] ?? $basename;
            $newPath      = $directory . '/' . $basename;

            Storage::disk('local')->move($tempPath, $newPath);

            TicketAttachment::create([
                'ticket_id'   => $ticket->id,
                'reply_id'    => null,
                'uploaded_by' => auth()->id(),
                'filename'    => $originalName,
                'path'        => $newPath,
                'mime_type'   => Storage::disk('local')->mimeType($newPath),
                'size'        => Storage::disk('local')->size($newPath),
            ]);

            $existing++;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
