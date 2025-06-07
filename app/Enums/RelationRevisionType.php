<?php

namespace App\Enums;

use App\Traits\HasTranslatableLabel;

enum RelationRevisionType: string
{
    use HasTranslatableLabel;
    case ATTACHING = 'attaching';
    case ATTACHED = 'attached';
    case DETACHING = 'detaching';
    case DETACHED = 'detached';
    case SYNCING = 'syncing';
    case SYNCED = 'synced';

    protected function translationPrefix(): string
    {
        return 'doceus.relation_revision_type';
    }
}
