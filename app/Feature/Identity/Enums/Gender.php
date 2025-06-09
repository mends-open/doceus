<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;

enum Gender: string
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
