<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptedBinary implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        // Value is stored as raw binary, re-encode to base64 for decryption
        return Crypt::decrypt(base64_encode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return base64_decode(Crypt::encrypt($value));
    }
}
