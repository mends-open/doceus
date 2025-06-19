<?php

namespace App\Models;

class PatientPractitioner extends BasePivot
{
    protected array $revisionable = [
        'patient_id',
        'practitioner_id',
    ];
}
