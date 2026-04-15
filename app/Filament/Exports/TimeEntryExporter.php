<?php

namespace App\Filament\Exports;

use App\Models\TimeEntry;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TimeEntryExporter extends Exporter
{
    protected static ?string $model = TimeEntry::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('ticket.title')
                ->label(__('time_entries.fields.ticket')),

            ExportColumn::make('user.name')
                ->label(__('time_entries.fields.user')),

            ExportColumn::make('minutes_spent')
                ->label(__('time_entries.fields.minutes_spent')),

            ExportColumn::make('notes')
                ->label(__('time_entries.fields.notes')),

            ExportColumn::make('created_at')
                ->label(__('time_entries.fields.created_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return __('time_entries.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);
    }
}
