<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;

enum OrganizationType: string
{
    use HasTranslatableLabel;
    case Individual = 'individual';
    case Entity = 'entity';

    protected function translationPrefix(): string
    {
        return 'doceus.organization_type';
    }
}
