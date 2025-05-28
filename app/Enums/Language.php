<?php

namespace App\Enums;

enum Language: string
{
    case EN = 'en';
    case PL = 'pl';

    public function label(): string
    {
        return match ($this) {
            self::EN => __('doceus.language.en'),
            self::PL => __('doceus.language.pl'),
        };
    }
}
