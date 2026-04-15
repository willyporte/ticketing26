<?php

namespace App\Filament\Resources\TimeEntryResource\Pages;

use App\Filament\Exports\TimeEntryExporter;
use App\Filament\Resources\TimeEntryResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListTimeEntries extends ListRecords
{
    protected static string $resource = TimeEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('time_entries.actions.create')),

            ExportAction::make()
                ->label(__('time_entries.actions.export'))
                ->exporter(TimeEntryExporter::class),
        ];
    }
}
