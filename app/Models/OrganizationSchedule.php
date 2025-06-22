<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $organization_id
 * @property int $schedule_id
 * @property-read Organization $organization
 * @property-read Schedule $schedule
 */
class OrganizationSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'organization_id',
        'schedule_id',
    ];
}
