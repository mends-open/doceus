<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use App\BlindIndex\BlindIndexer;

class BlindIndexUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        // Remove password, get email
        $email = $credentials['email'] ?? null;
        if (! $email) {
            return null;
        }
        $model = $this->createModel();

        return BlindIndexer::find($model, 'email', $email)
            ?? parent::retrieveByCredentials($credentials);
    }
}
