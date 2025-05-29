<?php

namespace App\Enums\Traits;

trait HasTranslatableLabel
{
    public function label(): string
    {
        return __($this->translationPrefix().$this->value);
    }

    // Each enum using this trait must implement this method
    abstract protected function translationPrefix(): string;
}
