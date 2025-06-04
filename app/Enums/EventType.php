<?php

namespace App\Enums;

use App\Traits\HasTranslatableLabel;

enum EventType: string
{
    use HasTranslatableLabel;

    case USER_REGISTERED = 'user_registered';
    case ORGANIZATION_REGISTERED = 'organization_registered';
    case LOGGED_IN = 'logged_in';
    case LOGGED_OUT = 'logged_out';
    case PASSWORD_RESET = 'password_reset';
    case PASSWORD_CHANGED = 'password_changed';
    case EMAIL_VERIFIED = 'email_verified';

    protected function translationPrefix(): string
    {
        return 'doceus.event_type';
    }
}
