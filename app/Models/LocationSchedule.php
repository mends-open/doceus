<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $location_id
 * @property int $schedule_id
 * @property-read Location $location
 * @property-read Schedule $schedule
 */
class LocationSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'location_id',
        'schedule_id',
    ];
}
