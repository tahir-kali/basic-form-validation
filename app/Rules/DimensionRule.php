<?php
//▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄         ▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄            ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄
//▐░░░░░░░░░░░▐░░░░░░░░░░░▐░▌       ▐░▐░░░░░░░░░░░▐░░░░░░░░░░░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌
// ▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▐░▌       ▐░▌▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▌           ▀▀▀▀▀▀▀▀▀█░▐░█░█▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌       ▐░▌                    ▐░▐░▌▐░▌    ▐░▌         ▐░▌         ▐░▌
//     ▐░▌    ▐░█▄▄▄▄▄▄▄█░▐░█▄▄▄▄▄▄▄█░▌    ▐░▌    ▐░█▄▄▄▄▄▄▄█░▌                    ▐░▐░▌ ▐░▌   ▐░▌         ▐░▌▄▄▄▄▄▄▄▄▄█░▌
//     ▐░▌    ▐░░░░░░░░░░░▐░░░░░░░░░░░▌    ▐░▌    ▐░░░░░░░░░░░▌           ▄▄▄▄▄▄▄▄▄█░▐░▌  ▐░▌  ▐░▌▄▄▄▄▄▄▄▄▄█░▐░░░░░░░░░░░▌
//     ▐░▌    ▐░█▀▀▀▀▀▀▀█░▐░█▀▀▀▀▀▀▀█░▌    ▐░▌    ▐░█▀▀▀▀█░█▀▀           ▐░░░░░░░░░░░▐░▌   ▐░▌ ▐░▐░░░░░░░░░░░▌▀▀▀▀▀▀▀▀▀█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌     ▐░▌            ▐░█▀▀▀▀▀▀▀▀▀▐░▌    ▐░▌▐░▐░█▀▀▀▀▀▀▀▀▀          ▐░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌▄▄▄▄█░█▄▄▄▄▐░▌      ▐░▌           ▐░█▄▄▄▄▄▄▄▄▄▐░█▄▄▄▄▄█░█░▐░█▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▐░░░░░░░░░░░▐░▌       ▐░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌
//      ▀      ▀         ▀ ▀         ▀ ▀▀▀▀▀▀▀▀▀▀▀ ▀         ▀            ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀ ▀▀▀▀▀▀▀▀▀▀▀

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
        $allowed_dimensions = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'element','size');
        if($width !== $allowed_dimensions['width'] || $height!== $allowed_dimensions['height']) $fail('The uploaded image has invalid dimension. Allowed dimensions are height: '.$allowed_dimensions['height'].' width: '.$allowed_dimensions['width']);
    }
}
