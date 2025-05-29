<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationRole extends Pivot
{
    protected $table = 'organization_role';
}
