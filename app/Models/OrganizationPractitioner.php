<?php

namespace App\Models;

/**
 * @property int $organization_id
 * @property int $practitioner_id
 */
class OrganizationPractitioner extends BasePivot
{
    protected array $revisionable = [
        'organization_id',
        'practitioner_id',
    ];
}
