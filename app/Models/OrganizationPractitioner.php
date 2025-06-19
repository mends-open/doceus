<?php

namespace App\Models;

use App\Models\Base\BasePivot;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $organization_id
 * @property int $practitioner_id
 *
 * @property-read Organization $organization
 * @property-read Practitioner $practitioner
 */

class OrganizationPractitioner extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'organization_id',
        'practitioner_id',
    ];
}
