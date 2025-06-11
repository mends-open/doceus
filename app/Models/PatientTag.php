<?php

namespace App\Models;

/**
 * @property int $patient_id
 * @property int $tag_id
 */
class PatientTag extends BasePivot
{
    protected array $revisionable = [
        'patient_id',
        'tag_id',
    ];
}
