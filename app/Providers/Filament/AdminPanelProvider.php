<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Profile;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->profile(Profile::class)
            ->multiFactorAuthentication([
                // TOTP via Google Authenticator (o altra app compatibile TOTP)
                // recoverable() abilita i codici di recupero monouso
                AppAuthentication::make()
                    ->recoverable()
                    ->brandName('TicketFlow'),

                // 2FA via email: invia un codice OTP all'email dell'utente ad ogni login
                EmailAuthentication::make(),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarWidth('12rem')// Usa rem, px, ecc.
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('screen-2xl')
            ->databaseNotifications()
            ->navigationGroups([
                'Supporto',
                'Amministrazione',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn(): HtmlString => new HtmlString(
                    Blade::render("@include('filament.pages.auth.login-demo-modal')")
                ),
                scopes: Login::class,
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn(): HtmlString => new HtmlString(<<<'HTML'
                <style>
                    /* Nasconde elementi x-cloak prima che Alpine si inizializzi */
                    [x-cloak] { display: none !important; }

                    /* Stat widget backgrounds — light mode */
                    .stat-open        { background-color: #fecaca !important; }
                    .stat-in-progress { background-color: #fde68a !important; }
                    .stat-waiting     { background-color: #e2e8f0 !important; }
                    .stat-resolved    { background-color: #bbf7d0 !important; }
                    .stat-closed      { background-color: #86efac !important; }

                    /* Stat widget backgrounds — dark mode */
                    .dark .stat-open        { background-color: rgba(127, 29,  29, 0.35) !important; }
                    .dark .stat-in-progress { background-color: rgba(120, 53,  15, 0.35) !important; }
                    .dark .stat-waiting     { background-color: rgba( 51, 65,  85, 0.35) !important; }
                    .dark .stat-resolved    { background-color: rgba( 20, 83,  45, 0.35) !important; }
                    .dark .stat-closed      { background-color: rgba( 22,101,  52, 0.45) !important; }

                    /* Collapsible widget toggle bar — light mode */
                    .fi-cw-toggle {
                        background-color: #ffffff;
                        border: 1px solid rgba(0,0,0,0.07);
                    }
                    .fi-cw-title { color: #111827; }
                    .fi-cw-arrow { color: #9ca3af; }

                    /* Collapsible widget toggle bar — dark mode */
                    .dark .fi-cw-toggle {
                        background-color: rgb(31, 41, 55);
                        border-color: rgba(255,255,255,0.08);
                    }
                    .dark .fi-cw-title { color: #f9fafb; }
                    .dark .fi-cw-arrow { color: #6b7280; }
                </style>
                HTML)
            );
    }
}
