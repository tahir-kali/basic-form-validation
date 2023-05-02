<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    protected array $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if (gettype($value) !== 'integer') {
            $fail($this->extractErrorMessageForField($this->field, "integer",$value));
        }

    }

    public function extractErrorMessageForField($field, $key,$value)
    {
        if(!isset($field['messages'])){
            foreach($field['validation'] as $validation){
                if($validation['rule'] === $key) return $validation['message'];
            }
        }
        foreach($field['messages'] as $message){
            if(isset($message[$key])) return $message[$key];
        }
        return "No Custom error message found for NumberRule";
    }
}
