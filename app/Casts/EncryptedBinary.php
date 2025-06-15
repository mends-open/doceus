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

        // Value is stored as raw binary; handle stream resources from PgSQL
        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        // Re-encode to base64 for decryption
        try {
            return Crypt::decrypt(base64_encode($value));
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

        return base64_decode(Crypt::encrypt($value));
    }
}
