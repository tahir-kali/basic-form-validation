<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use Closure;
use Exception;
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
       try{
           //
           $data_type = $this->field['data_type'];
           $max_val = $this->extractMaxVal();
           if (gettype($value) === "array" && count($value) > $max_val) {
               $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'max'));
           } else if(($data_type == "string" && strlen($value) > $max_val) || ($data_type == "integer" && $value > $max_val)){
               $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'max'));
           }
       }catch(Exception $e){
           dd($value);
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
}
