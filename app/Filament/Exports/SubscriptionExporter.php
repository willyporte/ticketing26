<?php

namespace App\Filament\Exports;

use App\Models\Subscription;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SubscriptionExporter extends Exporter
{
    protected static ?string $model = Subscription::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('company.name')
                ->label(__('subscriptions.fields.company')),

            ExportColumn::make('plan.name')
                ->label(__('subscriptions.fields.plan')),

            ExportColumn::make('minutes_remaining')
                ->label(__('subscriptions.fields.minutes_remaining')),

            ExportColumn::make('starts_at')
                ->label(__('subscriptions.fields.starts_at')),

            ExportColumn::make('expires_at')
                ->label(__('subscriptions.fields.expires_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return __('subscriptions.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);
    }
}
