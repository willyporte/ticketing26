<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketReply;
use App\Models\TimeEntry;
use App\Models\User;
use App\Notifications\TicketReplyAddedNotification;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Storage;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    // ─── Form vuoto: sopprime la sezione "Visualizza Ticket" auto-generata da
    //     Filament v5 (che rendererebbe la Resource form in sola lettura in
    //     parallelo all'infolist custom). Il contenuto del ticket è gestito
    //     interamente dall'infolist qui sotto.
    public function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    // ─── Mount ───────────────────────────────────────────────────────────────

    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Eager load allegati diretti al ticket e allegati delle risposte
        $this->record->load(['attachments', 'replies.attachments']);

        // Warning per lo staff: minuti esauriti sull'azienda del ticket
        if (! auth()->user()?->isClient()) {
            $subscription = $this->record->company?->activeSubscription();

            if ($subscription && $subscription->minutes_remaining <= 0) {
                Notification::make()
                    ->title(__('subscriptions.messages.minutes_exhausted'))
                    ->warning()
                    ->persistent()
                    ->send();
            }
        }
    }

    // ─── Azioni header ────────────────────────────────────────────────────────

    protected function getHeaderActions(): array
    {
        $acceptedMimeTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            'application/zip',
        ];

        return [

            // ── Risposta al ticket ────────────────────────────────────────────
            Actions\Action::make('addReply')
                ->label(__('tickets.replies.add'))
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->visible(fn (): bool => auth()->user()->can('createReply', $this->record))
                ->form(function () use ($acceptedMimeTypes): array {
                    $user = auth()->user();

                    $fields = [
                        RichEditor::make('body')
                            ->label(__('tickets.replies.body'))
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'bulletList', 'orderedList',
                                'blockquote', 'codeBlock',
                                'link',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),
                    ];

                    // Campo minuti: visibile solo allo staff (non ai Client)
                    if (! $user->isClient()) {
                        $subscription      = $this->record->company?->activeSubscription();
                        $minutesAvailable  = $subscription?->minutes_remaining ?? null;

                        $hint = $minutesAvailable !== null
                            ? __('time_entries.hints.available', ['minutes' => $minutesAvailable])
                            : __('time_entries.hints.no_subscription');

                        $fields[] = TextInput::make('minutes_spent')
                            ->label(__('time_entries.fields.minutes_spent'))
                            ->numeric()
                            ->minValue(0)
                            ->integer()
                            ->nullable()
                            ->hint($hint)
                            ->hintColor($minutesAvailable !== null && $minutesAvailable <= 0 ? 'danger' : 'gray');
                    }

                    $fields[] = FileUpload::make('reply_attachments')
                        ->label(__('tickets.attachments.add'))
                        ->multiple()
                        ->maxFiles(10)
                        ->maxSize(10240) // 10 MB in KB
                        ->acceptedFileTypes($acceptedMimeTypes)
                        ->disk('local')
                        ->directory('attachments/temp')
                        ->visibility('private')
                        ->storeFileNamesIn('reply_attachment_names');

                    return $fields;
                })
                ->action(function (array $data): void {
                    $reply = TicketReply::create([
                        'ticket_id' => $this->record->id,
                        'user_id'   => auth()->id(),
                        'body'      => $data['body'],
                    ]);

                    // ── Salvataggio allegati della risposta ───────────────────
                    $paths    = is_array($data['reply_attachments'] ?? null) ? $data['reply_attachments'] : [];
                    $names    = is_array($data['reply_attachment_names'] ?? null) ? $data['reply_attachment_names'] : [];
                    $existing = TicketAttachment::countForTicket($this->record->id);

                    if (! empty($paths)) {
                        $directory = "attachments/{$this->record->company_id}/{$this->record->id}";
                        Storage::disk('local')->makeDirectory($directory);

                        foreach ($paths as $tempPath) {
                            if ($existing >= 10) {
                                break;
                            }

                            if (! Storage::disk('local')->exists($tempPath)) {
                                continue;
                            }

                            $basename     = basename($tempPath);
                            $originalName = $names[$tempPath] ?? $names[$basename] ?? $basename;
                            $newPath      = $directory . '/' . $basename;

                            Storage::disk('local')->move($tempPath, $newPath);

                            TicketAttachment::create([
                                'ticket_id'   => null,
                                'reply_id'    => $reply->id,
                                'uploaded_by' => auth()->id(),
                                'filename'    => $originalName,
                                'path'        => $newPath,
                                'mime_type'   => Storage::disk('local')->mimeType($newPath),
                                'size'        => Storage::disk('local')->size($newPath),
                            ]);

                            $existing++;
                        }
                    }

                    // ── TimeEntry automatico se minuti inseriti dallo staff ───
                    $minutesSpent = isset($data['minutes_spent']) && $data['minutes_spent'] > 0
                        ? (int) $data['minutes_spent']
                        : null;

                    if ($minutesSpent && ! auth()->user()->isClient()) {
                        TimeEntry::create([
                            'ticket_id'     => $this->record->id,
                            'user_id'       => auth()->id(),
                            'minutes_spent' => $minutesSpent,
                            'notes'         => null,
                        ]);

                        // Scala i minuti dalla subscription attiva dell'azienda
                        $subscription = $this->record->company?->activeSubscription();
                        $subscription?->deductMinutes($minutesSpent);
                    }

                    // ── Auto-transizione stato ────────────────────────────────
                    // Se il ticket era "in attesa del cliente" e chi risponde è
                    // il cliente stesso, riportalo in_progress: segnala all'operatore
                    // che c'è nuova attività da gestire.
                    // Lo staff gestisce lo stato manualmente tramite le azioni header.
                    if (
                        $this->record->status === TicketStatus::WaitingClient &&
                        auth()->user()->isClient()
                    ) {
                        $this->record->update(['status' => TicketStatus::InProgress]);
                    }

                    $this->record->refresh();

                    // Notifica DB a tutti i partecipanti (escluso chi ha scritto).
                    // L'operatore assegnato riceve sempre questa notifica, indipendentemente
                    // dall'auto-transizione di stato — così sa che c'è una nuova risposta.
                    $this->notifyTicketParticipants(
                        new TicketReplyAddedNotification($this->record, auth()->user()),
                        excludeId: auth()->id(),
                    );

                    Notification::make()
                        ->title(__('tickets.replies.created'))
                        ->success()
                        ->send();
                }),

            // ── Prendi in carico (open → in_progress) ────────────────────────
            Actions\Action::make('takeInCharge')
                ->label(__('tickets.actions.take'))
                ->icon('heroicon-o-hand-raised')
                ->color('info')
                ->visible(fn (): bool =>
                    auth()->user()->can('assign', $this->record) &&
                    $this->record->status === TicketStatus::Open
                )
                ->form(function (): array {
                    if (auth()->user()->isOperator()) {
                        return [];
                    }

                    return [
                        \Filament\Forms\Components\Select::make('assigned_to')
                            ->label(__('tickets.fields.assigned_to'))
                            ->options(
                                User::whereIn('role', ['operator', 'supervisor'])
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )
                            ->searchable()
                            ->nullable()
                            ->placeholder(__('tickets.dashboard.unassigned')),
                    ];
                })
                ->modalHeading(__('tickets.actions.take'))
                ->modalSubmitActionLabel(__('tickets.actions.take'))
                ->action(function (array $data): void {
                    $updates = ['status' => TicketStatus::InProgress];

                    if (auth()->user()->isOperator()) {
                        $updates['assigned_to'] = auth()->id();
                    } elseif (! empty($data['assigned_to'])) {
                        $updates['assigned_to'] = $data['assigned_to'];
                    }

                    $this->record->update($updates);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.taken'))
                        ->success()
                        ->send();
                }),

            // ── Riprendi lavorazione (waiting_client → in_progress) ──────────
            Actions\Action::make('resume')
                ->label(__('tickets.actions.resume'))
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->visible(fn (): bool =>
                    auth()->user()->can('close', $this->record) &&
                    $this->record->status === TicketStatus::WaitingClient
                )
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update(['status' => TicketStatus::InProgress]);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.resumed'))
                        ->success()
                        ->send();
                }),

            // ── In attesa cliente (in_progress → waiting_client) ─────────────
            // Raggruppato con gli altri cambi di stato (risolto/chiudi/riapri)
            Actions\Action::make('waitingClient')
                ->label(__('tickets.actions.waiting_client'))
                ->icon('heroicon-o-clock')
                ->color('gray')
                ->visible(fn (): bool =>
                    auth()->user()->can('close', $this->record) &&
                    $this->record->status === TicketStatus::InProgress
                )
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update(['status' => TicketStatus::WaitingClient]);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.waiting_client'))
                        ->success()
                        ->send();
                }),

            // ── Segna come risolto ────────────────────────────────────────────
            Actions\Action::make('resolve')
                ->label(__('tickets.actions.resolve'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool =>
                    auth()->user()->can('close', $this->record) &&
                    ! in_array($this->record->status, [TicketStatus::Resolved, TicketStatus::Closed])
                )
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update(['status' => TicketStatus::Resolved]);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.resolved'))
                        ->success()
                        ->send();
                }),

            // ── Chiudi ticket ─────────────────────────────────────────────────
            Actions\Action::make('close')
                ->label(__('tickets.actions.close'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (): bool =>
                    auth()->user()->can('close', $this->record) &&
                    $this->record->status !== TicketStatus::Closed
                )
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update(['status' => TicketStatus::Closed]);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.closed'))
                        ->success()
                        ->send();
                }),

            // ── Riapri ticket ─────────────────────────────────────────────────
            Actions\Action::make('reopen')
                ->label(__('tickets.actions.reopen'))
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('warning')
                ->visible(fn (): bool =>
                    auth()->user()->can('reopen', $this->record) &&
                    in_array($this->record->status, [TicketStatus::Resolved, TicketStatus::Closed])
                )
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update(['status' => TicketStatus::Open]);
                    $this->record->refresh();

                    Notification::make()
                        ->title(__('tickets.messages.reopened'))
                        ->success()
                        ->send();
                }),

            // ── Info cliente / abbonamento ────────────────────────────────────
            Actions\Action::make('clientInfo')
                ->label(__('tickets.actions.client_info'))
                ->icon('heroicon-o-information-circle')
                ->color('gray')
                ->visible(fn (): bool => ! auth()->user()->isClient())
                ->modalHeading(__('tickets.actions.client_info'))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel(__('tickets.modal.close'))
                ->modalContent(function (): ViewContract {
                    $ticket       = $this->record->loadMissing(['creator', 'assignee', 'company.subscriptions.plan']);
                    $subscription = $ticket->company?->activeSubscription()?->loadMissing('plan');

                    return view('filament.modals.ticket-client-info', compact('ticket', 'subscription'));
                }),

            // ── Modifica ticket ───────────────────────────────────────────────
            Actions\EditAction::make()
                ->visible(fn (): bool => auth()->user()->can('update', $this->record)),
        ];
    }

    // ─── Helper notifiche ────────────────────────────────────────────────────

    private function notifyTicketParticipants(mixed $notification, ?int $excludeId = null): void
    {
        $ticket = $this->record;
        $ticket->loadMissing(['creator', 'assignee', 'replies.user']);

        $participants = collect();

        if ($ticket->creator)  $participants->push($ticket->creator);
        if ($ticket->assignee) $participants->push($ticket->assignee);

        $ticket->replies->each(fn ($reply) => $participants->push($reply->user));

        $participants
            ->filter()
            ->unique('id')
            ->reject(fn (User $u) => $excludeId && $u->id === $excludeId)
            ->each(fn (User $u) => $u->notify($notification));
    }

    // ─── Helper allegati ─────────────────────────────────────────────────────

    /**
     * Genera HTML con un link per riga: icona graffetta a sinistra + nome file + dimensione.
     * Usato sia per gli allegati diretti al ticket che per quelli delle risposte.
     */
    private static function attachmentLinksHtml(
        \Illuminate\Support\Collection $attachments,
        string $containerStyle = '',
    ): string {
        // Filament sanitizza l'HTML e rimuove tag <svg> inline.
        // Soluzione: SVG codificato come data URI in un <img> — mai rimosso dal purifier.
        $svg  = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" '
              . 'stroke-width="1.5" stroke="#6366f1">'
              . '<path stroke-linecap="round" stroke-linejoin="round" '
              . 'd="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94'
              . 'A3 3 0 1119.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81'
              . 'a1.5 1.5 0 002.112 2.13"/>'
              . '</svg>';
        $icon = '<img src="data:image/svg+xml;base64,' . \base64_encode($svg) . '" '
              . 'style="width:1rem;height:1rem;flex-shrink:0;" alt="" />';

        $rows = $attachments->map(function (TicketAttachment $a) use ($icon): string {
            $url  = route('attachments.download', $a);
            $name = htmlspecialchars($a->filename, ENT_QUOTES, 'UTF-8');
            $size = $a->formattedSize();

            return "<a href=\"{$url}\" target=\"_blank\" "
                 . "style=\"display:flex;align-items:center;gap:0.45rem;"
                 . "color:#6366f1;font-size:0.8rem;text-decoration:none;"
                 . "padding:0.2rem 0;\">"
                 . "<span style='color:#6366f1;flex-shrink:0;'>{$icon}</span>"
                 . "<span style='text-decoration:underline;'>{$name}</span>"
                 . "<span style='color:#9ca3af;font-size:0.75rem;margin-left:0.15rem;'>({$size})</span>"
                 . "</a>";
        })->implode('');

        return "<div style='display:flex;flex-direction:column;gap:0.1rem;{$containerStyle}'>{$rows}</div>";
    }

    // ─── Infolist ─────────────────────────────────────────────────────────────
    //
    // Ordine sezioni: Dettagli → Conversazione → Allegati → Tempo lavorato
    // Tutto in colonna singola — nessun ->columns() a nessun livello.
    // Dettagli e Conversazione: aperte di default.
    // Allegati e Tempo lavorato: collassate di default.

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([

            // ── 1. Dettagli ───────────────────────────────────────────────────

            Section::make(__('tickets.sections.details'))
                ->schema([
                    // Titolo e descrizione su tutta la larghezza
                    TextEntry::make('title')
                        ->label(__('tickets.fields.title'))
                        ->weight(FontWeight::Bold)
                        ->columnSpanFull(),

                    TextEntry::make('description')
                        ->label(__('tickets.fields.description'))
                        ->columnSpanFull(),

                    // Allegati diretti al ticket (caricati con l'apertura del ticket)
                    TextEntry::make('ticket_attachments_links')
                        ->hiddenLabel()
                        ->html()
                        ->columnSpanFull()
                        ->hidden(fn (Ticket $record): bool => $record->attachments->isEmpty())
                        ->getStateUsing(fn (Ticket $record): string =>
                            static::attachmentLinksHtml($record->attachments, 'padding:0.25rem 0;')
                        ),

                    // Campi brevi su 2 colonne
                    TextEntry::make('status')
                        ->label(__('tickets.fields.status'))
                        ->badge()
                        ->weight(FontWeight::Bold)
                        ->color(fn (TicketStatus $state): string => $state->color())
                        ->formatStateUsing(fn (TicketStatus $state): string => $state->label()),

                    TextEntry::make('priority')
                        ->label(__('tickets.fields.priority'))
                        ->badge()
                        ->weight(FontWeight::Bold)
                        ->color(fn (TicketPriority $state): string => $state->color())
                        ->formatStateUsing(fn (TicketPriority $state): string => $state->label()),

                    TextEntry::make('company.name')
                        ->label(__('tickets.fields.company'))
                        ->hidden(fn (): bool => auth()->user()->isClient()),

                    TextEntry::make('department.name')
                        ->label(__('tickets.fields.department'))
                        ->default('-'),

                    TextEntry::make('creator.name')
                        ->label(__('tickets.fields.created_by')),

                    TextEntry::make('assignee.name')
                        ->label(__('tickets.fields.assigned_to'))
                        ->default(__('tickets.dashboard.unassigned'))
                        ->hidden(fn (): bool => auth()->user()->isClient()),

                    TextEntry::make('created_at')
                        ->label(__('tickets.fields.created_at'))
                        ->dateTime('d/m/Y H:i')
                        ->timezone('Europe/Rome'),

                    TextEntry::make('updated_at')
                        ->label(__('tickets.fields.updated_at'))
                        ->dateTime('d/m/Y H:i')
                        ->timezone('Europe/Rome'),

                    // Minuti residui abbonamento — visibile solo allo staff
                    TextEntry::make('company.id')
                        ->label(__('tickets.fields.minutes_remaining'))
                        ->hidden(fn (): bool => auth()->user()->isClient())
                        ->badge()
                        ->state(function (Ticket $record): string {
                            $sub = $record->company?->activeSubscription();
                            if (! $sub) {
                                return __('tickets.modal.no_subscription');
                            }
                            $min = $sub->minutes_remaining;
                            $pct = $sub->remainingPercentage();
                            return "{$min} min ({$pct}%)";
                        })
                        ->color(function (Ticket $record): string {
                            $sub = $record->company?->activeSubscription();
                            if (! $sub) return 'gray';
                            if ($sub->minutes_remaining <= 0) return 'danger';
                            if ($sub->isBelowWarningThreshold()) return 'warning';
                            return 'success';
                        }),
                ])
                ->columns(2)
                ->collapsible(),

            // ── 2. Conversazione ──────────────────────────────────────────────
            Section::make(__('tickets.sections.replies'))
                ->schema([
                    RepeatableEntry::make('replies')
                        ->label('')
                        ->schema([
                            // Avatar con iniziali + nome — 2 colonne per la riga header della risposta
                            TextEntry::make('user.name')
                                ->hiddenLabel()
                                ->html()
                                ->formatStateUsing(function (string $state, TicketReply $record): string {
                                    $name = htmlspecialchars($state, ENT_QUOTES, 'UTF-8');
                                    $user = $record->user;

                                    // Foto profilo reale se presente, altrimenti circoletto con iniziali
                                    if ($user?->avatar_path) {
                                        $url        = Storage::disk('public')->url($user->avatar_path);
                                        $safeUrl    = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
                                        $avatarHtml = "<img src='{$safeUrl}' alt='{$name}'
                                                           style='width:2rem;height:2rem;border-radius:9999px;
                                                                  object-fit:cover;flex-shrink:0;'>";
                                    } else {
                                        $words    = preg_split('/\s+/', trim($state));
                                        $initials = strtoupper(
                                            substr($words[0] ?? '', 0, 1) .
                                            substr($words[1] ?? '', 0, 1)
                                        );
                                        $palette    = ['#6366f1','#8b5cf6','#ec4899','#ef4444',
                                                       '#f97316','#22c55e','#14b8a6','#3b82f6','#06b6d4'];
                                        $color      = $palette[abs(crc32($state)) % count($palette)];
                                        $avatarHtml = "<span style='background:{$color};
                                                                     min-width:2rem;width:2rem;height:2rem;
                                                                     border-radius:9999px;flex-shrink:0;
                                                                     display:flex;align-items:center;
                                                                     justify-content:center;
                                                                     color:#fff;font-size:0.7rem;font-weight:700;
                                                                    '>{$initials}</span>";
                                    }

                                    return "<div style='display:flex;align-items:center;gap:0.6rem;'>
                                                {$avatarHtml}
                                                <span style='font-weight:600;'>{$name}</span>
                                            </div>";
                                }),

                            TextEntry::make('created_at')
                                ->label(__('tickets.fields.created_at'))
                                ->dateTime('d/m/Y H:i')
                                ->timezone('Europe/Rome'),

                            TextEntry::make('body')
                                ->label(__('tickets.replies.body'))
                                ->html()
                                ->columnSpanFull(),

                            // Link allegati della risposta — visibile solo se presenti
                            TextEntry::make('reply_attachments_links')
                                ->hiddenLabel()
                                ->html()
                                ->columnSpanFull()
                                ->hidden(fn (TicketReply $record): bool => $record->attachments->isEmpty())
                                ->getStateUsing(fn (TicketReply $record): string =>
                                    static::attachmentLinksHtml(
                                        $record->attachments,
                                        'margin-top:0.5rem;padding-top:0.5rem;border-top:1px dashed rgba(0,0,0,0.1);'
                                    )
                                ),
                        ])
                        ->columns(2),
                ])
                ->collapsible(),

            // ── 3. Allegati ───────────────────────────────────────────────────
            // Aggrega allegati diretti (ticket_id) e allegati delle risposte
            // (reply_id) in un'unica lista ordinata per data.
            Section::make(__('tickets.sections.attachments'))
                ->schema([
                    RepeatableEntry::make('all_attachments')
                        ->label('')
                        ->state(fn (Ticket $record): \Illuminate\Support\Collection =>
                            TicketAttachment::where('ticket_id', $record->id)
                                ->orWhereIn('reply_id', $record->replies()->pluck('id'))
                                ->with('uploader')
                                ->orderBy('created_at')
                                ->get()
                        )
                        ->schema([
                            TextEntry::make('filename')
                                ->label(__('tickets.attachments.filename'))
                                ->url(fn (TicketAttachment $record): string => route('attachments.download', $record))
                                ->openUrlInNewTab(),

                            TextEntry::make('size')
                                ->label(__('tickets.attachments.size'))
                                ->formatStateUsing(fn (int $state): string =>
                                    $state >= 1_048_576
                                        ? round($state / 1_048_576, 1) . ' MB'
                                        : round($state / 1_024, 1) . ' KB'
                                ),

                            TextEntry::make('uploader.name')
                                ->label(__('tickets.attachments.uploaded_by')),

                            TextEntry::make('created_at')
                                ->label(__('tickets.attachments.uploaded_at'))
                                ->dateTime('d/m/Y H:i')
                                ->timezone('Europe/Rome'),
                        ]),
                ])
                ->collapsible()
                ->collapsed(),

            // ── 4. Tempo lavorato (solo staff) ───────────────────────────────
            Section::make(__('tickets.sections.time'))
                ->schema([
                    RepeatableEntry::make('timeEntries')
                        ->label('')
                        ->schema([
                            TextEntry::make('user.name')
                                ->label(__('time_entries.fields.user')),

                            TextEntry::make('minutes_spent')
                                ->label(__('time_entries.fields.minutes_spent'))
                                ->formatStateUsing(function (int $state): string {
                                    $hours   = intdiv($state, 60);
                                    $minutes = $state % 60;

                                    if ($hours > 0 && $minutes > 0) {
                                        return "{$hours}h {$minutes}m";
                                    }

                                    return $hours > 0 ? "{$hours}h" : "{$minutes}m";
                                }),

                            TextEntry::make('notes')
                                ->label(__('time_entries.fields.notes'))
                                ->default('-'),

                            TextEntry::make('created_at')
                                ->label(__('time_entries.fields.created_at'))
                                ->dateTime('d/m/Y H:i')
                                ->timezone('Europe/Rome'),
                        ]),
                ])
                ->collapsible()
                ->collapsed()
                ->hidden(fn (): bool => auth()->user()->isClient()),
        ])->columns(1);
    }
}
