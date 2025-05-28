<?php

namespace App\Enums;

enum UnitType: string
{
    case WITHOUT_PRACTICE = 'without_practice';

    public function label(): string
    {
        return match ($this) {
            self::WITHOUT_PRACTICE => __('doceus.unit.without_practice'),
        };

    }
}
