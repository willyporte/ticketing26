<?php

namespace App\Filament\Widgets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\HtmlString;

class UnassignedTicketsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = auth()->user();

        return ($user?->isAdministrator() || $user?->isSupervisor()) ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(new HtmlString(
                '<span style="display:inline-flex;align-items:center;gap:7px;">'
                . '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#f59e0b;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>'
                . __('dashboard.widgets.unassigned_tickets')
                . '</span>'
            ))
            ->query(fn () => Ticket::with(['company', 'department'])
                ->whereNull('assigned_to')
                ->whereNotIn('status', [TicketStatus::Resolved, TicketStatus::Closed])
                ->latest()
            )
            ->columns([
                TextColumn::make('title')
                    ->label(__('tickets.fields.title'))
                    ->limit(50)
                    ->searchable(),

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
