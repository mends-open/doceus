<?php

namespace App\Feature\Sqid\Traits;

use App\Feature\Sqid\Sqid;
use Sqids\Sqids;

trait HasSqids
{
    /**
     * Get the model's sqid value (pure, no prefix).
     */
    public function getSqidAttribute(): ?string
    {
        if ($this->id === null) {
            return null;
        }

        $alphabet = Sqid::modelAlphabet(static::class);
        if ($alphabet) {
            $config = config('sqid');
            $sqids = new Sqids(
                alphabet: $alphabet,
                minLength: $config['length'] ?? 10
            );

            return $sqids->encode([(int) $this->id]);
        }

        return Sqid::encode($this->id);
    }

    /**
     * Use pure sqid as route key.
     */
    public function getRouteKey(): string
    {
        return $this->sqid;
    }

    /**
     * Find model by sqid value (no prefix logic).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $alphabet = Sqid::modelAlphabet(static::class);
        if ($alphabet) {
            $config = config('sqid');
            $sqids = new Sqids(
                alphabet: $alphabet,
                minLength: $config['length'] ?? 10
            );
            $decoded = $sqids->decode($value);
            $id = isset($decoded[0]) ? (int) $decoded[0] : null;
        } else {
            $id = Sqid::decode($value);
        }

        return $id !== null ? $this->where('id', $id)->firstOrFail() : null;
    }
}
