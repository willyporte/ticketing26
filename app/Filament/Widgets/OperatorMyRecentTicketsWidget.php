<?php

namespace App\Filament\Widgets;

use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OperatorMyRecentTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isOperator() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('dashboard.widgets.my_recent_tickets'))
            ->query(
                Ticket::with(['company'])
                    ->where('assigned_to', auth()->id())
                    ->latest()
                    ->limit(5)
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

                TextColumn::make('company.name')
                    ->label(__('tickets.fields.company'))
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('tickets.fields.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome'),
            ])
            ->recordUrl(fn (Ticket $record): ?string =>
                TicketResource::getUrl('view', ['record' => $record])
            )
            ->paginationPageOptions([5])
            ->defaultPaginationPageOption(5);
    }
}
