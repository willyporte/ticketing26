<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Exports\SubscriptionExporter;
use App\Filament\Resources\SubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('subscriptions.actions.create')),

            ExportAction::make()
                ->label(__('subscriptions.actions.export'))
                ->exporter(SubscriptionExporter::class),
        ];
    }
}
