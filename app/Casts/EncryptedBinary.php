<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptedBinary implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        // Handle stream resources returned by PgSQL drivers
        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        try {
            return Crypt::decrypt($value);
        } catch (DecryptException) {
            // Fallback for legacy plaintext values
            return $value;
        }
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return Crypt::encrypt($value);
    }
}
