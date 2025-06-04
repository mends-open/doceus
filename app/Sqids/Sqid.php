<?php

namespace App\Sqids;

use Sqids\Sqids;

class Sqid
{
    protected static ?Sqids $sqids = null;

    /**
     * Get Sqid config from sqid.php.
     */
    protected static function config(): array
    {
        return config('sqid', [
            'length'   => 32,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
        ]);
    }

    /**
     * Get the current configured Sqids instance (singleton).
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
     * Re-initialize with fresh config (if called after config changes).
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
     * Encode an integer ID into a SQID string.
     */
    public static function encode(int|string $id): string
    {
        $id = (int)$id;
        return self::init()->encode([$id]);
    }

    /**
     * Decode a SQID string to an integer ID (or null).
     */
    public static function decode(string $sqid): ?int
    {
        $decoded = self::init()->decode($sqid);
        return isset($decoded[0]) ? (int)$decoded[0] : null;
    }
}
