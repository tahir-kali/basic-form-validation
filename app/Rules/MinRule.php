<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
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
        $data_type    = $this->field['data_type'];
        $min_val      = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'validation',
            'min_value');
        $errorMessage = FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'min');
        if (gettype($value) === "array" && count($value) < $min_val) {
            $fail($errorMessage);

            return;
        }
        if (($data_type == "string" && strlen($value) < $min_val) || ($data_type == "integer" && $value < $min_val)) {
            $fail($errorMessage);

            return;
        }

    }


}
