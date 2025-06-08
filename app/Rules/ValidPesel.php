<?php

namespace App\Rules;

use App\Feature\Person\Utils\Pesel;
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
