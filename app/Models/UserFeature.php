<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property string|null $organization_id
 * @property string|null $user_id
 * @property string|null $feature
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeature whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserFeature extends Pivot
{
    //
}
