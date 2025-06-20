<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $practitioner_id
 * @property int $schedule_id
 * @property-read Practitioner $practitioner
 * @property-read Schedule $schedule
 */
class PractitionerSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'practitioner_id',
        'schedule_id',
    ];
}
