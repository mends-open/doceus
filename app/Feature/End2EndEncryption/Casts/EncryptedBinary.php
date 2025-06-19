<?php

namespace App\Feature\End2EndEncryption\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class EncryptedBinary implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return is_null($value)
            ? null
            : Crypt::decryptString(base64_encode($value));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return is_null($value)
            ? null
            : base64_decode(Crypt::encryptString($value));
    }
}
