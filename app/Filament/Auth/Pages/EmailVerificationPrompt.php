<?php

namespace App\Filament\Auth\Pages;

use Filament\Actions\Action;
use Filament\Auth\Pages\EmailVerification\EmailVerificationPrompt as BaseEmailVerificationPrompt;
use Filament\Facades\Filament;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;

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

    public function loginAction(): Action
    {
        return Action::make('login')
            ->label(__('filament-panels::auth/pages/login.title'))
            ->url(route('filament.app.auth.login'));
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Text::make(__('filament-panels::auth/pages/email-verification/email-verification-prompt.messages.notification_sent', [
                    'email' => filament()->auth()->user()->getEmailForVerification(),
                ])),
                Text::make(new HtmlString(
                    __('filament-panels::auth/pages/email-verification/email-verification-prompt.messages.notification_not_received').
                    ' '.
                    $this->resendNotificationAction->toHtml(),
                )),
                Actions::make([
                    $this->logoutAction(),
                    $this->loginAction(),
                ])->fullWidth(),
            ]);
    }
}
