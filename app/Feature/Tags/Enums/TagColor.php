<?php

namespace App\Feature\Tags\Enums;

use App\Traits\HasTranslatableLabel;

/**
 * Standard color names supported by Filament.
 */
enum TagColor: string
{
    use HasTranslatableLabel;

    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
    case Info = 'info';
    case Primary = 'primary';
    case Gray = 'gray';

    protected function translationPrefix(): string
    {
        return 'doceus.tag_color';
    }
}
