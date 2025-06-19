<?php

namespace App\Models;

use App\Models\Base\BasePivot;
use Illuminate\Database\Eloquent\Model;

class OrganizationPatient extends BasePivot
{
    protected array $revisionable = [
        'organization_id',
        'patient_id',
    ];
}
