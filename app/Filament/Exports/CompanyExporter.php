<?php

namespace App\Filament\Exports;

use App\Models\Company;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CompanyExporter extends Exporter
{
    protected static ?string $model = Company::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label(__('companies.fields.name')),

            ExportColumn::make('vat_number')
                ->label(__('companies.fields.vat_number')),

            ExportColumn::make('email')
                ->label(__('companies.fields.email')),

            ExportColumn::make('phone')
                ->label(__('companies.fields.phone')),

            ExportColumn::make('created_at')
                ->label(__('companies.fields.created_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return __('companies.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);
    }
}
