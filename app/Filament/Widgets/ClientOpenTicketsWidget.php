<?php

namespace App\Filament\Widgets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ClientOpenTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isClient() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('dashboard.widgets.my_open_tickets'))
            ->query(
                Ticket::where('created_by', auth()->id())
                    ->whereIn('status', [
                        TicketStatus::Open,
                        TicketStatus::InProgress,
                        TicketStatus::WaitingClient,
                    ])
                    ->latest()
            )
            ->columns([
                TextColumn::make('title')
                    ->label(__('tickets.fields.title'))
                    ->limit(50),

                TextColumn::make('status')
                    ->label(__('tickets.fields.status'))
                    ->badge()
                    ->color(fn (TicketStatus $state): string => $state->color())
                    ->formatStateUsing(fn (TicketStatus $state): string => $state->label()),

                TextColumn::make('priority')
                    ->label(__('tickets.fields.priority'))
                    ->badge()
                    ->color(fn (TicketPriority $state): string => $state->color())
                    ->formatStateUsing(fn (TicketPriority $state): string => $state->label()),

                TextColumn::make('updated_at')
                    ->label(__('tickets.fields.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable(),
            ])
            ->recordUrl(fn (Ticket $record): ?string =>
                TicketResource::getUrl('view', ['record' => $record])
            )
            ->paginationPageOptions([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
