<?php

namespace App\Filament\Auth\Pages;

use Filament\Actions\Action;
use Filament\Auth\Pages\EmailVerification\EmailVerificationPrompt as BaseEmailVerificationPrompt;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Session;

class EmailVerificationPrompt extends BaseEmailVerificationPrompt
{
    public function logoutAction(): Action
    {
        return Action::make('logout')
            ->label(__('filament-panels::layout.actions.logout.label'))
            ->icon(
                FilamentIcon::resolve('panels::user-menu.logout-button')
                ?? Heroicon::ArrowLeftOnRectangle
            )
            ->action(function () {
                Filament::auth()->logout();

                Session::invalidate();
                Session::regenerateToken();

                return redirect()->route('filament.app.auth.login');
            });
    }

    // Render hook for logout action is registered in the panel provider.
}
