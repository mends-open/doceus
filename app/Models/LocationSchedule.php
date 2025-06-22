<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $schedule_id
 * @property int $location_id
 */
class LocationSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'schedule_id',
        'location_id',
    ];
}
