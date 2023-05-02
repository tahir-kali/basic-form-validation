<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InRule implements ValidationRule
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

        $values = $this->extractFieldValuesIntoArray($this->field);

        if(!in_array($value,$values)){

            $fail($this->extractErrorMessageForField($value));
        }

    }
    public function extractFieldValuesIntoArray($field): array
    {

        $valueArr = [];
        foreach ($field['values'] as $val) {
            foreach($val['values'] as $val2){
                array_push($valueArr,  $val2["value"]);
            }
        }

        return $valueArr;
    }
    public function extractErrorMessageForField($value){
       return "The value '$value' does not exist! Please supply correct values! Allowed values: ".json_encode($this->extractFieldValuesIntoArray($this->field));
    }
}
