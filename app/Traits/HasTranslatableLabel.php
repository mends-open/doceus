<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait HasTranslatableLabel
{
    public function getLabel(): string
    {
        return __(
            Arr::join([$this->translationPrefix(), $this->value], '.')
        );
    }

    public function label(): string
    {
        return $this->getLabel();
    }

    // Each enum using this trait must implement this method
    abstract protected function translationPrefix(): string;
}
