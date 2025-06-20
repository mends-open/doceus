<?php

namespace App\Feature\Scheduling\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum RepeatPattern: string implements HasLabel
{
    use HasTranslatableLabel;

    case None = 'none';
    case Weekly = 'weekly';

    protected function translationPrefix(): string
    {
        return 'doceus.repeat_pattern';
    }
}
