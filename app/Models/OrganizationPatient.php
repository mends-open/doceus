<?php

namespace App\Models;

class OrganizationPatient extends BasePivot
{
    protected array $revisionable = [
        'patient_id',
        'organization_id',
    ];
}
