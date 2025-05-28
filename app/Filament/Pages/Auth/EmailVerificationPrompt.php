<?php

namespace App\Filament\Pages\Auth;

use App\Notifications\EncryptedVerifyEmailNotification as VerifyEmail;
use Exception;
use Filament\Facades\Filament;
use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt as BasePage;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EmailVerificationPrompt extends BasePage
{

    protected function sendEmailVerificationNotification(MustVerifyEmail $user): void
    {
        if ($user->hasVerifiedEmail()) {
            return;
        }

        if (! method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = app(VerifyEmail::class);
        $notification->url = Filament::getVerifyEmailUrl($user);

        $user->notify($notification);
    }
}
