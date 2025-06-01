<?php

namespace App\Utilities\BlindIndex\Traits;

use App\Utilities\BlindIndex\Support\BlindIndex;

trait HasBlindIndex
{
    protected static function bootHasBlindIndex(): void
    {
        static::saving(function ($model) {
            BlindIndex::for($model)->update();
        });
    }

    /**
     * Get the model fields configured for blind indexing.
     */
    public function getBlindIndexFields(): array
    {
        if (! property_exists($this, 'blind')) {
            return [];
        }

        $blind = $this->blind;

        return array_is_list($blind) ? $blind : array_keys($blind);
    }

    public static function makeBlindIndex(string $value): string
    {
        return BlindIndex::hash($value);
    }

    public static function findByBlindIndex(string $field, string $value): ?self
    {
        $indexField = $field.'_blind';
        $instance = new static;
        if (! in_array($field, $instance->getBlindIndexFields())) {
            throw new \InvalidArgumentException("Field [$field] is not configured for blind indexing.");
        }
        $index = static::makeBlindIndex($value);

        return static::where($indexField, $index)->first();
    }
}
