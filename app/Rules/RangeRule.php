<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RangeRule implements ValidationRule
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
        if(!isset($value) || empty($value) || $value === null){
            $fail($this->extractErrorMessageForField($this->field,"required"));
        }

    }
    public function extractErrorMessageForField($field,$key){
        foreach($field['validation'] as $validation){
            if($validation["rule"] === $key) return $validation['message'];
        }
    }
}
