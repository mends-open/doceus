<?php

namespace App\Enums;

enum OrganizationType: string
{
    case INDIVIDUAL = 'individual';
    case GROUP_PRACTICE = 'group_practice';
    case MEDICAL_ENTITY = 'medical_entity';
}
