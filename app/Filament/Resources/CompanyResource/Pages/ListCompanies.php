<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Exports\CompanyExporter;
use App\Filament\Resources\CompanyResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('companies.actions.create')),

            ExportAction::make()
                ->label(__('companies.actions.export'))
                ->exporter(CompanyExporter::class),
        ];
    }
}
