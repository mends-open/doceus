<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlindIndex
{
    protected Model $model;

    /**
     * Create a new instance for the given model.
     */
    public static function for(Model $model): static
    {
        $instance = new static;
        $instance->model = $model;

        return $instance;
    }

    /**
     * Update blind index columns for the model.
     */
    public function update(?array $fields = null): void
    {
        $fields = $fields ?? $this->getFields();

        foreach ($fields as $field) {
            if ($this->model->isDirty($field)) {
                $indexField = $field.'_blind_index';
                $this->model->{$indexField} = static::hash($this->model->{$field});
            }
        }
    }

    /**
     * Get the configured blind index fields from the model.
     */
    protected function getFields(): array
    {
        if (! method_exists($this->model, 'getBlindIndexFields')) {
            return [];
        }

        return $this->model->getBlindIndexFields();
    }

    /**
     * Generate a blind index for the given value.
     */
    public static function hash(string $value): string
    {
        $normalized = Str::of($value)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));

        return hash_hmac('sha256', $normalized, $hmacKey);
    }
}
