<?php

namespace App\Feature\Scheduling\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum DayOfWeek: int implements HasLabel
{
    use HasTranslatableLabel;

    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    protected function translationPrefix(): string
    {
        return 'doceus.day_of_week';
    }
}
