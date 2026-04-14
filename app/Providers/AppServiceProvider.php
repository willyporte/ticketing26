<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Observers\TicketObserver;
use App\Observers\TimeEntryObserver;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Notifiche sugli eventi del Ticket
        Ticket::observe(TicketObserver::class);

        // Scala/ripristina i minuti della subscription ad ogni TimeEntry
        TimeEntry::observe(TimeEntryObserver::class);

        // Azioni nelle righe delle tabelle Filament: solo icona, nessun testo
        EditAction::configureUsing(fn (EditAction $action) => $action->iconButton());
        DeleteAction::configureUsing(fn (DeleteAction $action) => $action->iconButton());
        ViewAction::configureUsing(fn (ViewAction $action) => $action->iconButton());
    }
}
