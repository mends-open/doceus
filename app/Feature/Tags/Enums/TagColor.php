<?php

namespace App\Feature\Tags\Enums;

use App\Traits\HasTranslatableLabel;

/**
 * Standard color names supported by Filament.
 */
enum TagColor: string
{
    use HasTranslatableLabel;

    case Slate = 'slate';
    case Gray = 'gray';
    case Zinc = 'zinc';
    case Neutral = 'neutral';
    case Stone = 'stone';
    case Red = 'red';
    case Orange = 'orange';
    case Amber = 'amber';
    case Yellow = 'yellow';
    case Lime = 'lime';
    case Green = 'green';
    case Emerald = 'emerald';
    case Teal = 'teal';
    case Cyan = 'cyan';
    case Sky = 'sky';
    case Blue = 'blue';
    case Indigo = 'indigo';
    case Violet = 'violet';
    case Purple = 'purple';
    case Fuchsia = 'fuchsia';
    case Pink = 'pink';
    case Rose = 'rose';

    protected function translationPrefix(): string
    {
        return 'doceus.tag_color';
    }
}
