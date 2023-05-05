<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
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
        if (FieldServiceFacade::failsToConvertToDataType($value,"integer") === true) {
            $fail($this->extractErrorMessageForField($this->field, "integer"));
        }
    }

    public function extractErrorMessageForField($field, $key)
    {
        if(!isset($field['messages'])){
            foreach($field['validation'] as $validation){
                if($validation['rule'] === $key) return $validation['message'];
            }
        }
        foreach($field['messages'] as $message){
            if(isset($message[$key])) return $message[$key];
        }
        return "This field only accepts numbers";
    }
}
