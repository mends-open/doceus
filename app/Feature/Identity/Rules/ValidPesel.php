<?php

namespace App\Feature\Identity\Rules;

use App\Feature\Identity\Services\Pesel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPesel implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^\d{11}$/', $value)) {
            $fail(__('doceus.pesel.exact-eleven-digits'));

            return;
        }

        if (! Pesel::isValid($value)) {
            $fail(__('doceus.pesel.invalid'));
        }
    }
}
