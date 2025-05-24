<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;

class EloquentBlindIndexUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        // Remove password, get email
        $email = $credentials['email'] ?? null;
        if (! $email) {
            return null;
        }
        $model = $this->createModel();
        if (method_exists($model, 'findByBlind')) {
            return $model->findByBlind('email', $email);
        }

        // fallback
        return parent::retrieveByCredentials($credentials);
    }
}
