<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected array $field;
    public function __construct($field){
        $this->field = $field;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if(gettype($value) !== 'string'){
            $fail($this->extractErrorMessageForField());
        }
    }

    public function extractErrorMessageForField(){
        return "Illegal data type supplied to the field";
    }
}
