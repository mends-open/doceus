<?php

namespace App\Notifications;

use Filament\Notifications\Auth\ResetPassword as FilamentResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class EncryptedResetPasswordNotification extends FilamentResetPasswordNotification implements ShouldBeEncrypted
{
    // You inherit everything.
    // Optionally override toMail() for custom text/branding.
    // No extra code is needed for encryption.
}
