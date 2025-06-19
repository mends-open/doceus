<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use HasTranslatableLabel;

    case Male = 'male';
    case Female = 'female';
    case Other = 'other';
    case Unknown = 'unknown';

    protected function translationPrefix(): string
    {
        return 'doceus.gender';
    }
}
