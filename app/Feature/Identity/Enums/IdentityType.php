<?php

namespace App\Feature\Identity\Enums;

enum IdentityType: string
{
    case Passport = 'passport';
    case IdentityCard = 'identity_card';
    case Other = 'other';
}
