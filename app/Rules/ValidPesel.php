<?php

namespace App\Rules;

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
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $weights[$i] * (int) $value[$i];
        }
        $control = (10 - ($sum % 10)) % 10;
        if ($control !== (int) $value[10]) {
            $fail(__('doceus.pesel.invalid'));
        }
    }
}
