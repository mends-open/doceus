<?php

namespace App\Feature\Revision\Enums;

use App\Traits\HasTranslatableLabel;

enum RevisionType: string
{
    use HasTranslatableLabel;
    case Created = 'created';
    case Updated = 'updated';
    case Deleted = 'deleted';
    case Restored = 'restored';
    case ForceDeleted = 'force_deleted';

    protected function translationPrefix(): string
    {
        return 'doceus.revision_type.';
    }
}
