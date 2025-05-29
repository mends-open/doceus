<?php

namespace App\Enums\Traits;

use Illuminate\Support\Arr;

trait HasTranslatableLabel
{
    public function label(): string
    {
        return __(
            Arr::join([$this->translationPrefix(), $this->value], '.')
        );
    }

    // Each enum using this trait must implement this method
    abstract protected function translationPrefix(): string;
}
