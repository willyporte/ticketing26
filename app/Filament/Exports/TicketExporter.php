<?php

namespace App\Filament\Exports;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TicketExporter extends Exporter
{
    protected static ?string $model = Ticket::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('title')
                ->label(__('tickets.fields.title')),

            ExportColumn::make('status')
                ->label(__('tickets.fields.status'))
                ->formatStateUsing(fn (string $state): string => TicketStatus::from($state)->label()),

            ExportColumn::make('priority')
                ->label(__('tickets.fields.priority'))
                ->formatStateUsing(fn (string $state): string => TicketPriority::from($state)->label()),

            ExportColumn::make('company.name')
                ->label(__('tickets.fields.company')),

            ExportColumn::make('department.name')
                ->label(__('tickets.fields.department')),

            ExportColumn::make('creator.name')
                ->label(__('tickets.fields.created_by')),

            ExportColumn::make('assignee.name')
                ->label(__('tickets.fields.assigned_to')),

            ExportColumn::make('created_at')
                ->label(__('tickets.fields.created_at')),

            ExportColumn::make('updated_at')
                ->label(__('tickets.fields.updated_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return __('tickets.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);
    }
}
