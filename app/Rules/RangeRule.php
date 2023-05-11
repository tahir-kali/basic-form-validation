<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RangeRule implements ValidationRule
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
        $minMax = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'validation', 'range');
        if (!$minMax || $value === null) {
            return;
        }

        if (gettype($value) === 'array') {
            if (count($value) < $minMax['min_value'] || count($value) > $minMax['max_value']) {
                $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'range'));
            }

            return;
        }
        if (intval($value) < intval($minMax['min_value']) || intval($value) > intval($minMax['max_value'])) {
            $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'range'));

            return;
        }

    }
}
