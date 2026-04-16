<?php

namespace App\Filament\Widgets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.collapsible-table-widget';

    public function getCollapsibleHeading(): string
    {
        return __('dashboard.widgets.recent_tickets');
    }

    public function getCollapsibleIcon(): string
    {
        return 'heroicon-o-ticket';
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        return ($user?->isAdministrator() || $user?->isSupervisor()) ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->query(
                Ticket::with(['company'])->latest()
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

                TextColumn::make('company.name')
                    ->label(__('tickets.fields.company'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('tickets.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->timezone('Europe/Rome'),
            ])
            ->paginationPageOptions([5])
            ->defaultPaginationPageOption(5);
    }
}
