<?php

namespace App\Feature\MorphClass\Enums;

enum MorphClass: string
{
    case User = 'user';
    case Organization = 'organization';
    case OrganizationPractitioner = 'organization_practitioner';
    case Person = 'person';
    case ContactPoint = 'contact_point';
}
