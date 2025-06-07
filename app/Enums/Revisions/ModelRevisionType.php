<?php

namespace App\Enums\Revisions;

use App\Traits\HasTranslatableLabel;

enum ModelRevisionType: string
{
    use HasTranslatableLabel;

    case RETRIEVED = 'retrieved';
    case CREATING = 'creating';
    case CREATED = 'created';
    case UPDATING = 'updating';
    case UPDATED = 'updated';
    case SAVING = 'saving';
    case SAVED = 'saved';
    case DELETING = 'deleting';
    case DELETED = 'deleted';
    case RESTORING = 'restoring';
    case RESTORED = 'restored';
    case REPLICATING = 'replicating';

    protected function translationPrefix(): string
    {
        return 'doceus.model_revision_type';
    }
}
