<?php

namespace App\Feature\Scheduling\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum ScheduleType: string implements HasLabel
{
    use HasTranslatableLabel;

    case Availability = 'availability';
    case Block = 'block';

    protected function translationPrefix(): string
    {
        return 'doceus.schedule_type';
    }
}
