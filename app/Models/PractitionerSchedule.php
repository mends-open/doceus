<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $schedule_id
 * @property int $practitioner_id
 */
class PractitionerSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'schedule_id',
        'practitioner_id',
    ];
}
