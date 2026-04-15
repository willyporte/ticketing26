<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Exports\TicketExporter;
use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn (): bool => auth()->user()->can('create', \App\Models\Ticket::class)),

            ExportAction::make()
                ->label(__('tickets.actions.export'))
                ->exporter(TicketExporter::class),
        ];
    }
}
