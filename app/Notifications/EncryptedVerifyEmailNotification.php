<?php

namespace App\Notifications;

use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class EncryptedVerifyEmailNotification extends VerifyEmail implements ShouldBeEncrypted {}
