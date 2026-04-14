<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SubscriptionResource;
use App\Models\Subscription;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AdminSubscriptionWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isAdministrator() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('dashboard.widgets.subscriptions_overview'))
            ->query(
                Subscription::with(['company', 'plan'])
                    ->active()
                    ->orderBy('expires_at')
            )
            ->columns([
                TextColumn::make('company.name')
                    ->label(__('subscriptions.fields.company'))
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('plan.name')
                    ->label(__('subscriptions.fields.plan'))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('minutes_remaining')
                    ->label(__('subscriptions.fields.minutes_remaining'))
                    ->badge()
                    ->icon(fn (Subscription $record): string => $record->isBelowWarningThreshold()
                        ? 'heroicon-o-exclamation-triangle'
                        : 'heroicon-o-check-circle'
                    )
                    ->color(fn (Subscription $record): string => match (true) {
                        $record->minutes_remaining <= 0    => 'danger',
                        $record->isBelowWarningThreshold() => 'warning',
                        default                            => 'success',
                    })
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label(__('subscriptions.fields.expires_at'))
                    ->date('d/m/Y')
                    ->icon('heroicon-o-calendar-days')
                    ->sortable(),
            ])
            ->recordUrl(fn (Subscription $record): ?string =>
                auth()->user()?->can('update', $record)
                    ? SubscriptionResource::getUrl('edit', ['record' => $record])
                    : null
            )
            ->striped()
            ->paginated(false);
    }
}
