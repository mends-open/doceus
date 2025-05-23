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
        // Use the model's blind-index-based lookup
        if (method_exists($model, 'findByEmail')) {
            return $model->findByEmail($email);
        }

        // fallback
        return parent::retrieveByCredentials($credentials);
    }
}
