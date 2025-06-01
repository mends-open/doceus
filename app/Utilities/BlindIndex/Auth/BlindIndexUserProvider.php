<?php

namespace App\Utilities\BlindIndex\Auth;

use Illuminate\Auth\EloquentUserProvider;

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
        if (method_exists($model, 'findByBlindIndex')) {
            return $model->findByBlindIndex('email', $email);
        }

        // fallback
        return parent::retrieveByCredentials($credentials);
    }
}
