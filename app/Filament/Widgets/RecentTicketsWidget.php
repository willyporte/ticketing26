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
        return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;display:inline-block;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a3 3 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z"/></svg>'
            . __('dashboard.widgets.recent_tickets');
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
