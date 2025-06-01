<?php

namespace App\Enums;

use App\Traits\HasTranslatableLabel;

enum OrganizationType: string
{
    use HasTranslatableLabel;
    case INDIVIDUAL = 'individual';
    case ENTITY = 'entity';

    protected function translationPrefix(): string
    {
        return 'doceus.organization_type';
    }
}
