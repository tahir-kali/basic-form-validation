<?php

namespace App\Rules;

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
            $fail($this->extractErrorMessageForField($this->field, "min"));
        } else {
            if (($data_type == "string" && strlen($value) < $min_val) || ($data_type == "integer" && $value < $min_val)) {
                $fail($this->extractErrorMessageForField($this->field, "min"));
            }
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

    public function extractErrorMessageForField($field, $key)
    {
        if (!isset($field['messages'])) {
            foreach ($field['validation'] as $validation) {
                if ($validation['rule'] === $key) {
                    return $validation['message'];
                }
            }
        } else {
            foreach ($field['messages'] as $message) {
                if (isset($message[$key])) {
                    return $message[$key];
                }
            }
        }

        return "No Custom error message found for MinRule!";
    }
}
