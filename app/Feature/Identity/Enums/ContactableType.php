<?php

namespace App\Feature\Identity\Enums;

enum ContactableType: string
{
    case Person = 'person';
    case Organization = 'organization';
}
