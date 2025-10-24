<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SoloMayusculas implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Permitir solo mayúsculas, espacios, acentos y caracteres especiales comunes
        return preg_match('/^[A-ZÁÉÍÓÚÑÜ\s\.\-\(\)]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute solo permite mayúsculas con acentos.';
    }
}