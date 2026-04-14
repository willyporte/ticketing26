<?php

namespace App\Filament\Widgets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OperatorAvailableTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isOperator() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('dashboard.widgets.available_tickets'))
            ->query(
                Ticket::with(['company'])
                    ->whereNull('assigned_to')
                    ->where('status', TicketStatus::Open)
                    ->latest()
            )
            ->columns([
                TextColumn::make('title')
                    ->label(__('tickets.fields.title'))
                    ->limit(50),

                TextColumn::make('company.name')
                    ->label(__('tickets.fields.company'))
                    ->sortable(),

                TextColumn::make('priority')
                    ->label(__('tickets.fields.priority'))
                    ->badge()
                    ->color(fn (TicketPriority $state): string => $state->color())
                    ->formatStateUsing(fn (TicketPriority $state): string => $state->label()),

                TextColumn::make('created_at')
                    ->label(__('tickets.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome')
                    ->sortable(),
            ])
            ->recordUrl(fn (Ticket $record): ?string =>
                auth()->user()?->can('update', $record)
                    ? TicketResource::getUrl('edit', ['record' => $record])
                    : null
            )
            ->paginationPageOptions([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
