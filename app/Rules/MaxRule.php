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

class MaxRule implements ValidationRule
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
        $max_val      = FieldServiceFacade::extractValuesFromFieldParamsOrValidation($this->field, 'validation',
            'max_value');
        $errorMessage = FieldServiceFacade::extractErrorMessageFromFieldObject($this->field, 'max');
        if (is_array($value) && count($value) > $max_val) {
            $fail($errorMessage);
            return;
        }
        if (($data_type == "string" && strlen($value) > $max_val) || ($data_type == "integer" && $value > $max_val)) {
            $fail($errorMessage);
            return;
        }

    }

    public function extractMaxVal()
    {

        foreach ($this->field['validation'] as $validation) {
            if ($validation['rule'] === 'max') {
                return $validation['params']["max_value"];
            }
            if ($validation['rule'] === 'range') {
                return $validation['params']['max_value'];
            }
        }
    }
}
