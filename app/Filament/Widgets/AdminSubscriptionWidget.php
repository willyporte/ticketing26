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

    protected string $view = 'filament.widgets.collapsible-table-widget';

    public function getCollapsibleHeading(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;display:inline-block;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 21Z"/></svg>'
            . __('dashboard.widgets.subscriptions_overview');
    }

    public static function canView(): bool
    {
        return auth()->user()?->isAdministrator() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
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
