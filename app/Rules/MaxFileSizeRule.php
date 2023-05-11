<?php

namespace App\Rules;

use App\Facades\FieldServiceFacade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxFileSizeRule implements ValidationRule
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
        $max_file_size = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'element','max_file_size');
        if($value->getSize() > $max_file_size){
            $fail('The uploaded file is too huge! Allowed file size: '.$max_file_size);
        }
    }
}
