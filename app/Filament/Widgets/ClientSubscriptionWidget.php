<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientSubscriptionWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->isClient() ?? false;
    }

    protected function getStats(): array
    {
        $user         = auth()->user();
        $subscription = $user?->company?->activeSubscription();

        if (! $subscription) {
            return [
                Stat::make(__('dashboard.stats.status'), __('dashboard.stats.no_subscription'))
                    ->color('danger'),
            ];
        }

        return [
            Stat::make(
                __('dashboard.stats.minutes_remaining'),
                max(0, $subscription->minutes_remaining)
            )->color($subscription->isBelowWarningThreshold() ? 'danger' : 'success'),

            Stat::make(
                __('dashboard.stats.expires_at'),
                $subscription->expires_at->format('d/m/Y')
            )->color($subscription->isActive() ? 'success' : 'danger'),
        ];
    }
}
