<?php

namespace App\Feature\Identity\Enums;

use App\Traits\HasTranslatableLabel;

enum PractitionerQualification: string
{
    use HasTranslatableLabel;

    case General = 'general';
    case Specialist = 'specialist';

    protected function translationPrefix(): string
    {
        return 'doceus.practitioner_qualification';
    }
}
