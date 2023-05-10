<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use App\Facades\LogServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Fork\Fork;

class ArrayRule implements ValidationRule
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
        $errorMessage = FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'array');
        if (gettype($value) !== 'array' || $value === null) {
            $fail($errorMessage);
        }
    }
}
