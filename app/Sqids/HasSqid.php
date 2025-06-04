<?php

namespace App\Sqids;

use Illuminate\Support\Str;
use Sqids\Sqids;

trait HasSqid
{
    // Set this on your model to control the case: 'snake', 'kebab', 'studly', or 'camel'
    // protected static string $sqidPrefixCase = 'snake';
    // To use a custom prefix base (not class name):
    // protected static string $sqidPrefixBase = 'custom';

    /**
     * Get the prefix case setting, either per-model or default.
     */
    protected function getSqidPrefixCase(): string
    {
        return property_exists(static::class, 'sqidPrefixCase')
            ? static::$sqidPrefixCase
            : 'snake';
    }

    /**
     * Determine the separator to use based on the prefix case.
     */
    protected function getSqidPrefixSeparator(): string
    {
        return match ($this->getSqidPrefixCase()) {
            'snake'  => '_',
            'kebab'  => '-',
            default  => '', // studly & camel usually have no separator
        };
    }

    /**
     * Case conversion based on the chosen type.
     */
    protected function casePrefix(string $value): string
    {
        return match ($this->getSqidPrefixCase()) {
            'snake'  => Str::snake($value),
            'kebab'  => Str::kebab($value),
            'studly' => Str::studly($value),
            'camel'  => Str::camel($value),
            default  => Str::snake($value),
        };
    }

    /**
     * Get the base of the prefix (class name or overridden by property).
     */
    protected function getSqidPrefixBase(): string
    {
        if (property_exists(static::class, 'sqidPrefixBase')) {
            return static::$sqidPrefixBase;
        }
        return class_basename(static::class);
    }

    /**
     * Get the prefix used for this model's SQID, case-aware and with separator if needed.
     */
    public function getSqidPrefix(): string
    {
        return $this->casePrefix($this->getSqidPrefixBase()) . $this->getSqidPrefixSeparator();
    }

    /**
     * Get the model's sqid, with prefix and using per-model alphabet if configured.
     */
    public function getSqidAttribute(): ?string
    {
        $prefix = $this->getSqidPrefix();
        if ($this->id === null) {
            return null;
        }

        // Use the model-specific alphabet if present in the config
        $alphabet = Sqid::modelAlphabet(static::class);
        if ($alphabet) {
            $config = config('sqid');
            $sqids = new Sqids(
                alphabet: $alphabet,
                minLength: $config['length'] ?? 10
            );
            $encoded = $sqids->encode([(int)$this->id]);
        } else {
            $encoded = Sqid::encode($this->id);
        }

        return $prefix . $encoded;
    }

    public function getRouteKey(): string
    {
        return $this->sqid;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $prefix = $this->getSqidPrefix();
        $sqid = Str::startsWith($value, $prefix)
            ? Str::after($value, $prefix)
            : $value;

        $alphabet = Sqid::modelAlphabet(static::class);
        if ($alphabet) {
            $config = config('sqid');
            $sqids = new Sqids(
                alphabet: $alphabet,
                minLength: $config['length'] ?? 10
            );
            $decoded = $sqids->decode($sqid);
            $id = isset($decoded[0]) ? (int)$decoded[0] : null;
        } else {
            $id = Sqid::decode($sqid);
        }

        return $id !== null ? $this->where('id', $id)->firstOrFail() : null;
    }
}
