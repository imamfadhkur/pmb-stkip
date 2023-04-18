<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ThreeDiffVal implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value[0] === $value[1] || $value[0] === $value[2] || $value[1] === $value[2]) {
            $fail('Pilihan prodi tidak boleh sama.');
        }
    }
}
