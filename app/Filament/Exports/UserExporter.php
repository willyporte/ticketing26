<?php

namespace App\Filament\Exports;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label(__('users.fields.name')),

            ExportColumn::make('email')
                ->label(__('users.fields.email')),

            ExportColumn::make('role')
                ->label(__('users.fields.role'))
                ->formatStateUsing(fn (string $state): string => UserRole::from($state)->label()),

            ExportColumn::make('company.name')
                ->label(__('users.fields.company')),

            ExportColumn::make('created_at')
                ->label(__('users.fields.created_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return __('users.export.completed', [
            'count' => number_format($export->successful_rows),
        ]);
    }
}
