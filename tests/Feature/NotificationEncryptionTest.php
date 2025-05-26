<?php

namespace Tests\Feature;

use App\Notifications\EncryptedResetPasswordNotification;
use App\Notifications\EncryptedVerifyEmailNotification;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Tests\TestCase;

class NotificationEncryptionTest extends TestCase
{
    public function test_notifications_implement_encryption(): void
    {
        $reset = new EncryptedResetPasswordNotification('token');
        $verify = new EncryptedVerifyEmailNotification();

        $this->assertInstanceOf(ShouldBeEncrypted::class, $reset);
        $this->assertInstanceOf(ShouldBeEncrypted::class, $verify);
    }
}
