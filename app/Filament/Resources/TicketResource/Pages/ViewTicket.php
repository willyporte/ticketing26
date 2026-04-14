<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketReplyAddedNotification;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    // ─── Mount ───────────────────────────────────────────────────────────────

    public function mount(int | string $record): void
    {
        parent::mount($record);

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
        return [

            // ── Risposta al ticket ────────────────────────────────────────────
            Actions\Action::make('addReply')
                ->label(__('tickets.replies.add'))
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->visible(fn (): bool => auth()->user()->can('createReply', $this->record))
                ->form([
                    Textarea::make('body')
                        ->label(__('tickets.replies.body'))
                        ->required()
                        ->rows(5),
                ])
                ->action(function (array $data): void {
                    TicketReply::create([
                        'ticket_id' => $this->record->id,
                        'user_id'   => auth()->id(),
                        'body'      => $data['body'],
                    ]);

                    $this->record->refresh();

                    // Notifica DB a tutti i partecipanti (escluso chi ha scritto)
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
                        Select::make('assigned_to')
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

            // ── In attesa cliente (in_progress → waiting_client) ─────────────
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

    // ─── Infolist ─────────────────────────────────────────────────────────────

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([

            // ── Dettagli ticket ──────────────────────────────────────────────
            Section::make(__('tickets.sections.details'))
                ->schema([
                    TextEntry::make('title')
                        ->label(__('tickets.fields.title'))
                        ->weight(FontWeight::Bold)
                        ->columnSpanFull(),

                    TextEntry::make('description')
                        ->label(__('tickets.fields.description'))
                        ->columnSpanFull(),

                    TextEntry::make('status')
                        ->label(__('tickets.fields.status'))
                        ->badge()
                        ->color(fn (TicketStatus $state): string => $state->color())
                        ->formatStateUsing(fn (TicketStatus $state): string => $state->label()),

                    TextEntry::make('priority')
                        ->label(__('tickets.fields.priority'))
                        ->badge()
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
                ])
                ->columns(2),

            // ── Conversazione / Risposte ─────────────────────────────────────
            Section::make(__('tickets.sections.replies'))
                ->schema([
                    RepeatableEntry::make('replies')
                        ->label('')
                        ->schema([
                            TextEntry::make('user.name')
                                ->label(__('users.fields.name'))
                                ->weight(FontWeight::SemiBold),

                            TextEntry::make('created_at')
                                ->label(__('tickets.fields.created_at'))
                                ->dateTime('d/m/Y H:i')
                                ->timezone('Europe/Rome'),

                            TextEntry::make('body')
                                ->label(__('tickets.replies.body'))
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ]),

            // ── Allegati ─────────────────────────────────────────────────────
            Section::make(__('tickets.sections.attachments'))
                ->schema([
                    RepeatableEntry::make('attachments')
                        ->label('')
                        ->schema([
                            TextEntry::make('filename')
                                ->label(__('tickets.attachments.filename')),

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
                        ])
                        ->columns(2),
                ]),

            // ── Tempo lavorato (solo staff) ───────────────────────────────────
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
                        ])
                        ->columns(2),
                ])
                ->hidden(fn (): bool => auth()->user()->isClient()),
        ]);
    }
}
