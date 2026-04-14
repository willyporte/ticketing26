<?php

namespace App\Filament\Widgets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OperatorStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected array | int | null $columns = 3;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isOperator() ?? false;
    }

    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make(__('tickets.dashboard.open'), Ticket::where('assigned_to', $userId)->where('status', TicketStatus::Open)->count())
                ->icon('heroicon-o-folder-open')
                ->color('info'),

            Stat::make(__('tickets.dashboard.in_progress'), Ticket::where('assigned_to', $userId)->where('status', TicketStatus::InProgress)->count())
                ->icon('heroicon-o-arrow-path')
                ->color('warning'),

            Stat::make(__('tickets.dashboard.waiting_client'), Ticket::where('assigned_to', $userId)->where('status', TicketStatus::WaitingClient)->count())
                ->icon('heroicon-o-clock')
                ->color('gray'),
        ];
    }
}
