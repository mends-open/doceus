<?php

namespace App\Models;

use App\Models\Base\BasePivot;

class PatientPractitioner extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'patient_id',
        'practitioner_id',
    ];
}
