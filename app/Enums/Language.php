<?php

namespace App\Enums;

enum Language: string
{
    case English = 'en';
    case Polish = 'pl';

    public function label(): string
    {
        return match ($this) {
            self::English => __('doceus.language.en'),
            self::Polish => __('doceus.language.pl'),
        };
    }
}
