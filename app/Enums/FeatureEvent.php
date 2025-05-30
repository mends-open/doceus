<?php

namespace App\Enums;

use App\Enums\Traits\HasTranslatableLabel;

enum FeatureEvent: string
{
    use HasTranslatableLabel;

    case GRANTED = 'granted';
    case REVOKED = 'revoked';

    protected function translationPrefix(): string
    {
        return 'doceus.feature_event';
    }
}
