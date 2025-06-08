<?php

namespace App\Feature\MorphClass\Enums;

enum MorphClass: string
{
    case User = 'user';
    case Organization = 'organization';
    case OrganizationUser = 'organization_user';
    case Person = 'person';
}
