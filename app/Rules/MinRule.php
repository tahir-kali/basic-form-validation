<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use App\Facades\LogServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinRule implements ValidationRule
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
        $data_type = $this->field['data_type'];
        $min_val   = $this->extractMinVal();

        if (gettype($value) === "array" && count($value) < $min_val) {

            $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'min'));
        }
        if (($data_type == "string" && strlen($value) < $min_val) || ($data_type == "integer" && $value < $min_val)) {
            $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'min'));
        }

    }

    public function extractMinVal()
    {
        foreach ($this->field['validation'] as $validation) {

            if ($validation['rule'] === 'min') {
                if (isset($validation['params']["min_value"])) {
                    return $validation['params']["min_value"];
                }
                if (isset($validation['params']["mix_value"])) {
                    return $validation['params']["mix_value"];
                }
            }
            if ($validation['rule'] === 'range') {
                return $validation['params']['min_value'];
            }
        }
    }

}
