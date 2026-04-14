<?php

namespace App\Filament\Widgets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected array | int | null $columns = 5;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isAdministrator() ?? false;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('tickets.dashboard.open'), Ticket::where('status', TicketStatus::Open)->count())
                ->icon('heroicon-o-folder-open')
                ->color('info'),

            Stat::make(__('tickets.dashboard.in_progress'), Ticket::where('status', TicketStatus::InProgress)->count())
                ->icon('heroicon-o-arrow-path')
                ->color('warning'),

            Stat::make(__('tickets.dashboard.waiting_client'), Ticket::where('status', TicketStatus::WaitingClient)->count())
                ->icon('heroicon-o-clock')
                ->color('gray'),

            Stat::make(__('tickets.dashboard.resolved'), Ticket::where('status', TicketStatus::Resolved)->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(__('tickets.dashboard.closed'), Ticket::where('status', TicketStatus::Closed)->count())
                ->icon('heroicon-o-lock-closed')
                ->color('danger'),
        ];
    }
}
