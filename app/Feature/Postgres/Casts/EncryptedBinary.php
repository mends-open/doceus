<?php

namespace App\Feature\Postgres\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\PostgresConnection;
use Illuminate\Support\Facades\Crypt;
use SodiumException;

class EncryptedBinary implements CastsAttributes
{
    /** Postgres ↔️ base64 wrapper
     */
    private function pgDecrypt(string $cipher): mixed
    {
        return Crypt::decrypt($cipher);
    }

    private function pgEncrypt(mixed $value): string
    {
        return Crypt::encrypt($value);
    }

    /** Streams → string, strings stay strings */
    private function toString(mixed $value): string
    {
        if (is_resource($value)) {
            rewind($value);

            return stream_get_contents($value) ?: '';
        }

        return $value;
    }

    private function isPg(Model $model): bool
    {
        return $model->getConnection() instanceof PostgresConnection;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        $value = $this->toString($value);

        return $this->isPg($model) ? $this->pgDecrypt($value) : $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        return $this->isPg($model) ? $this->pgEncrypt($value) : $value;
    }
}
