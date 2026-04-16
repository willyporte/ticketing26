<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;

class Login extends BaseLogin
{
    /**
     * Aggiunge il pannello credenziali demo sotto il form di login.
     */
    public function content(Schema $schema): Schema
    {
        return $schema->components([
            RenderHook::make(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE),
            $this->getFormContentComponent(),
            $this->getMultiFactorChallengeFormContentComponent(),
            RenderHook::make(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER),
            View::make('filament.pages.auth.login-demo-credentials'),
        ]);
    }
}
