<?php

namespace App\Models;

use App\Domain\Revision\Interfaces\Revisionable;
use App\Domain\Revision\Observers\RevisionableObserver;
use App\Domain\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property string $organization_id
 * @property string $user_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereUserId($value)
 *
 * @property int $id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([RevisionableObserver::class])]
class OrganizationUser extends Pivot implements Revisionable
{
    use LogsRevisions;

    public $incrementing = true;

    protected array $revisionable = [
        'organization_id',
        'user_id',
    ];
}
