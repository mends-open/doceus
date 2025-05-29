<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationRole extends Pivot
{
    use HasUuids;

    protected $table = 'organization_role';
}
