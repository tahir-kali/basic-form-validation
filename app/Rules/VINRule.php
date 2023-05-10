<?php

namespace App\Rules;

use App\Facades\LogServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class VINRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[A-HJ-NPR-Z\d]{8}[\dX][A-HJ-NPR-Z\d]{2}\d{6}$/';
        if(!preg_match($pattern, $value)){
            $fail("The VIN must be a valid 17-character string containing letters and numbers");
        }
    }
}
