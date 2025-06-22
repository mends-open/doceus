<?php

namespace App\Models;

use App\Models\Base\BasePivot;

/**
 * @property int $id
 * @property int $schedule_id
 * @property int $organization_id
 */
class OrganizationSchedule extends BasePivot
{
    public $incrementing = true;

    protected array $revisionable = [
        'schedule_id',
        'organization_id',
    ];
}
