<?php

namespace App\Feature\Scheduling\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum SlotStatus: string implements HasLabel
{
    use HasTranslatableLabel;

    case Free = 'free';
    case Booked = 'booked';
    case Blocked = 'blocked';

    protected function translationPrefix(): string
    {
        return 'doceus.slot_status';
    }
}
