<?php

namespace App\Services\Sqids;

use Illuminate\Support\Str;
use Sqids\Sqids;

class Sqid
{
    protected static ?Sqids $sqids = null;

    /**
     * Get Sqid config from config/sqid.php.
     */
    protected static function config(): array
    {
        return config('sqid');
    }

    /**
     * Get the currently configured Sqids instance (singleton).
     */
    public static function init(): Sqids
    {
        if (self::$sqids === null) {
            $config = self::config();
            self::$sqids = new Sqids(
                alphabet: $config['alphabet'],
                minLength: $config['length']
            );
        }

        return self::$sqids;
    }

    /**
     * Re-initialize with current config (e.g. after config changes).
     */
    public static function refresh(): void
    {
        $config = self::config();
        self::$sqids = new Sqids(
            alphabet: $config['alphabet'],
            minLength: $config['length']
        );
    }

    /**
     * Encode an integer or string ID into a SQID string.
     */
    public static function encode(int|string $id): string
    {
        $id = (int) $id;

        return self::init()->encode([$id]);
    }

    /**
     * Decode a SQID string to an integer ID (or null).
     */
    public static function decode(string $sqid): ?int
    {
        $decoded = self::init()->decode($sqid);

        return isset($decoded[0]) ? (int) $decoded[0] : null;
    }

    /**
     * Get the per-model alphabet if available, otherwise the default.
     *
     * @param  string  $model  Model class name or snake-case name.
     */
    public static function modelAlphabet(string $model): ?string
    {
        $config = self::config();
        $snake = Str::snake(class_basename($model));

        return $config['alphabets'][$snake] ?? $config['alphabet'] ?? null;
    }
}
