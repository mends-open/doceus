<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum OrganizationType: string implements HasLabel
{
    use HasTranslatableLabel;
    case Individual = 'individual';
    case Entity = 'entity';

    protected function translationPrefix(): string
    {
        return 'doceus.organization_type';
    }
}
