<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $organization_id
 * @property int $practitioner_id
 */
#[ObservedBy([RevisionableObserver::class])]
class OrganizationPractitioner extends Pivot implements Revisionable
{
    use LogsRevisions;

    public $incrementing = false;

    protected array $revisionable = [
        'organization_id',
        'practitioner_id',
    ];
}
