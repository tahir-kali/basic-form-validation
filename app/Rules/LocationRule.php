<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class LocationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
           $fail("Invalid values supplied");
        }
        foreach ($value as $coordinate) {
            $regex = '/^(-?\d{1,3})\.(\d{6})$/';
            if(!preg_match($regex, $coordinate)){
                $fail("Please supply a value like 23.123456");
            }
        }

    }


}
