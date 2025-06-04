<?php

namespace App\Enums;

use App\Traits\HasTranslatableLabel;

enum RevisionType: string
{
    use HasTranslatableLabel;

    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
    case RESTORED = 'restored';

    protected function translationPrefix(): string
    {
        return 'doceus.revision_type';
    }
}
