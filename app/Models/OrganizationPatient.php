<?php

namespace App\Models;

use App\Models\Base\BasePivot;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $organization_id
 * @property int $patient_id
 *
 * @property-read Organization $organization
 * @property-read Patient $patient
 */

class OrganizationPatient extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'organization_id',
        'patient_id',
    ];
}
