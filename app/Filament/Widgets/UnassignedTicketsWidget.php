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
                . \Blade::render('<x-heroicon-o-exclamation-triangle style="width:18px;height:18px;color:#f59e0b;flex-shrink:0;" />')
                . e(__('dashboard.widgets.unassigned_tickets'))
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
