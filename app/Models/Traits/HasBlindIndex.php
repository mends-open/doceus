<?php

namespace App\Models\Traits;

trait HasBlindIndex
{
    protected static function bootHasBlindIndex(): void
    {
        static::saving(function ($model) {
            foreach ($model->getBlindIndexAttributes() as $attribute) {
                if ($model->isDirty($attribute)) {
                    $indexField = $attribute.'_blind_index';
                    $model->{$indexField} = static::makeBlindIndex($model->{$attribute});
                }
            }
        });
    }

    /**
     * Generate a blind index for a value.
     */
    public function getBlindIndexAttributes(): array
    {
        return property_exists($this, 'blind') ? $this->blind : [];
    }

    public static function makeBlindIndex(string $value): string
    {
        $normalized = \Illuminate\Support\Str::of($value)->lower()->trim();
        $hmacKey = base64_decode(\Illuminate\Support\Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));

        return hash_hmac('sha256', $normalized, $hmacKey);
    }

    public static function findByBlindIndex(string $field, string $value): ?self
    {
        $indexField = $field.'_blind_index';
        $instance = new static;
        if (! in_array($field, $instance->getBlindIndexAttributes())) {
            throw new \InvalidArgumentException("Field [$field] is not configured for blind indexing.");
        }
        $index = static::makeBlindIndex($value);

        return static::where($indexField, $index)->first();
    }
}
