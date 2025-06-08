<?php

namespace App\Enums;

use App\Traits\HasTranslatableLabel;

enum Gender: string
{
    use HasTranslatableLabel;

    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    protected function translationPrefix(): string
    {
        return 'doceus.gender';
    }
}
