<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SoloMayusculas implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Permitir cualquier texto, el sistema lo convertirá a mayúsculas
        if (empty($value)) {
            $fail('El campo :attribute es requerido.');
        }
    }
}