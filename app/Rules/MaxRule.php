<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxRule implements ValidationRule
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
        $data_type = $this->field['data_type'];
        $max_val = $this->extractMaxVal();
        if (gettype($value) === "array" && count($value) > $max_val) {
            $fail($this->extractErrorMessageForField($this->field, "max"));
        } else if(($data_type == "string" && strlen($value) > $max_val) || ($data_type == "integer" && $value > $max_val)){
            $fail($this->extractErrorMessageForField($this->field,"max")." value: ".$max_val);
        }

    }
    public function extractMaxVal(){
        foreach($this->field['validation'] as $validation){
            if($validation['rule'] === 'max'){
                return $validation['params']["max_value"];
            }
            if($validation['rule'] === 'range'){
                return $validation['params']['max_value'];
            }
        }
    }
    public function extractErrorMessageForField($field,$key){
        if(!isset($field['messages'])){
            foreach($field['validation'] as $validation){
                if(in_array($validation['rule'],["max","range"])) return $validation['message'];
            }
        }else{
            foreach($field['messages'] as $message){
                if(in_array($message[$key])) return $message[$key];
            }
        }

        return "No Custom error message found for MaxRule!";
    }
}
