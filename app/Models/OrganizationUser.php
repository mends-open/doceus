<?php

namespace App\Models;

use App\Revisions\LogsRevisions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 *
 *
 * @property string $organization_id
 * @property string $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereUserId($value)
 * @mixin \Eloquent
 */
class OrganizationUser extends Pivot
{
    use LogsRevisions;

    public $timestamps = false;
}
