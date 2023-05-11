<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DimensionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected array $field;
    public function __construct($field)
    {
        $this->field = $field;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $data = getimagesize($value);
        if(!$data) return;
        $width = $data[0];
        $height = $data[1];
        $allowedDimentinos = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'element','size');
        if($width !== $allowedDimentinos['width'] || $height!== $allowedDimentinos['height']) $fail('The uploaded image has invalid dimension. Allowed dimensions are height: '.$allowedDimentinos['height'].' width: '.$allowedDimentinos['width']);
    }
}
