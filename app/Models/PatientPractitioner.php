<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $practitioner_id
 *
 * @property-read Patient $patient
 * @property-read Practitioner $practitioner
 */

class PatientPractitioner extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'patient_id',
        'practitioner_id',
    ];
}
