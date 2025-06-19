<?php

namespace App\Models;

use App\Models\Base\BasePivot;
use Illuminate\Database\Eloquent\Model;

class OrganizationPractitioner extends BasePivot
{
    protected array $revisionable = [
        'organization_id',
        'practitioner_id',
    ];
}
