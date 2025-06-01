<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property string|null $organization_id
 * @property string|null $feature
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeature whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationFeature whereOrganizationId($value)
 * @mixin \Eloquent
 */
class OrganizationFeature extends Pivot
{
    //
}
