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
        if (gettype($value)!== 'integer' && intval($value) === null) {
            $fail(FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'number'));
        }
    }


}
