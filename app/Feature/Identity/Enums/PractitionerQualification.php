<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;
use Filament\Support\Contracts\HasLabel;

enum PractitionerQualification: string implements HasLabel
{
    use HasTranslatableLabel;

    case General = 'general';
    case Specialist = 'specialist';

    protected function translationPrefix(): string
    {
        return 'doceus.practitioner_qualification';
    }
}
