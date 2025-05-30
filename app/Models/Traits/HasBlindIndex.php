<?php

namespace App\Models\Traits;

trait HasBlindIndex
{
    protected static function bootHasBlindIndex(): void
    {
        static::saving(function ($model) {
            \App\Database\BlindIndex::updateModel($model);
        });
    }

    /**
     * Generate a blind index for a value.
     */
    public function getBlindIndexFields(): array
    {
        if (! property_exists($this, 'blindIndexes')) {
            return [];
        }

        $blind = $this->blindIndexes;

        return array_is_list($blind) ? $blind : array_keys($blind);
    }


    public static function makeBlindIndex(string $value): string
    {
        return \App\Database\BlindIndex::hash($value);
    }

    public static function findByBlindIndex(string $field, string $value): ?self
    {
        $indexField = $field.'_blind_index';
        $instance = new static;
        if (! in_array($field, $instance->getBlindIndexFields())) {
            throw new \InvalidArgumentException("Field [$field] is not configured for blind indexing.");
        }
        $index = \App\Database\BlindIndex::hash($value);

        return static::where($indexField, $index)->first();
    }
}
