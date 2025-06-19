<?php

namespace App\Feature\Identity\Enums;

use Filament\Support\Contracts\HasLabel;

enum Language: string implements HasLabel
{
    case English = 'en';
    case Polish = 'pl';

    public function getLabel(): string
    {
        return match ($this) {
            self::English => __('doceus.language.en'),
            self::Polish => __('doceus.language.pl'),
        };
    }

    public function label(): string
    {
        return $this->getLabel();
    }
}
