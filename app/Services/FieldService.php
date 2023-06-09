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

namespace App\Services;

use App\Contracts\FieldServiceContract;
use App\Facades\ExceptionServiceFacade;
use App\Rules\ArrayRule;
use App\Rules\DimensionRule;
use App\Rules\InRule;
use App\Rules\MaxFileSizeRule;
use App\Rules\MaxRule;
use App\Rules\MediaRule;
use App\Rules\MinRule;
use App\Rules\NullableRule;
use App\Rules\NumberRule;
use App\Rules\RangeRule;
use App\Rules\RequiredRule;
use App\Rules\StringRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

final class FieldService implements FieldServiceContract
{
    public function failsToConvertToDataType(mixed $value, string $type): bool
    {
        $dataTypeConversionArray = [
            'string'  => strval($value),
            'integer' => intval($value),
        ];
        return $dataTypeConversionArray[$type] === null;
    }

    public function getValuesCSV(array $field): array
    {
        return data_get($field, 'values.*.value');
    }

    public function validateFieldMetaData(array $field): bool
    {
        $keysToExist = ['id', 'data_type', 'validation'];
        if (Arr::has($field, $keysToExist)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomValidationRule(array $field, ?string $rule = null): ValidationRule
    {

        if (!$rule) {
            return $this->returnTypeRule($field);
        }
        $customValidationArray = $this->getCustomValidationArray($field);
        $dataTypeRules         = $this->getDataTypeRules($field);
        $specialRules          = $this->getSpecialRules($field);

        if (isset($customValidationArray[$rule])) {
            return $customValidationArray[$rule];
        }

        if (isset($dataTypeRules[$rule])) {
            return $dataTypeRules[$rule];
        }

        if (isset($specialRules[$rule])) {
            return $specialRules[$rule];
        }

        return new NullableRule($field);
    }

//    Rules Start

    public function getCustomValidationArray(array $field): array
    {
        return [
            'required'  => new RequiredRule($field),
            'min'       => new MinRule($field),
            'max'       => new MaxRule($field),
            'min_value' => new MinRule($field),
            'mix_value' => new MinRule($field),
            'max_value' => new MaxRule($field),
            'range'     => new RangeRule($field),
        ];
    }

    public function getDataTypeRules(array $field): array
    {
        return [
            'string'  => new StringRule($field),
            'integer' => new NumberRule($field),
            'array'   => new ArrayRule($field),
        ];
    }

    public function getSpecialRules(array $field): array
    {
        return [
            'max_file_size' => new MaxFileSizeRule($field),
            'images'        => new MediaRule('image'),
            'required'      => new RequiredRule($field),
            'in'            => new InRule($field),
            'size'          => new DimensionRule($field),
        ];
    }

    public function returnTypeRule(array $field): ValidationRule
    {
        $data_type_rules = FieldService::getDataTypeRules($field);
        $data_type       = gettype($field['values'][0]['value']);
        return $data_type_rules[$data_type];
    }

//    Rules End
    public function extractValidationRules(array $field): array
    {
        $validation_arr    = [];
        $validationClasses = $this->getCustomValidationArray($field);
        foreach ($field['validation'] as $validation) {
            $rule = $validation['rule']; // required, min, max
            if (isset($validationClasses[$rule])) {
                $validation_arr[] = $validationClasses[$rule];
            }
        }

        return $validation_arr;
    }

    public function articulateErrorMessageForField(array $field): array
    {
        $messages = [];

        if (isset($field['validation'])) {
            foreach ($field['validation'] as $validation) {
                $messages[$validation['rule']] = $validation['message'];
            }
        } else {
            ExceptionServiceFacade::throwError('validation_not_found');
        }

        return $messages;
    }

    public function returnAdditionalFieldProperties(array $field): array
    {
        $resultArr        = [
            'child_validations' => [],
        ];
        $keys_to_ignore   = ['min', 'max', 'multiple', 'width', 'height'];
        $child_properties = $this->getSpecialRules($field);
        foreach (data_get($field, 'element.params') as $key => $value) {
            if (!in_array($key, $keys_to_ignore)) {
                $resultArr['child_validations'][] = $child_properties[$key];
            }
        }
        if ($field['slug'] === 'images') {
            $resultArr['child_validations'][] = $this->getCustomValidationRule($field, 'images');
        }
        if (!empty($field['values'])) {
            $resultArr['child_validations'][] = $this->getCustomValidationRule($field);
            $resultArr['child_validations'][] = $this->getCustomValidationRule($field, 'in');
        }

        return $resultArr;
    }

    public function extractErrorMessageFromFieldObject(array $field, string $rule): string
    {
        $errorMessages = [
            'string' => 'This field accepts only string values',
            'array'  => 'This field accepts only arrays',
            'number' => 'This field accepts only numbers',
            ...$this->articulateErrorMessageForField($field),
        ];
        if (isset($errorMessages[$rule])) {
            return $errorMessages[$rule];
        }

        return "No custom error message set for $rule";
    }

    public function extractValuesFromFieldParamsOrValidation(array $field, string $key, string $what): mixed
    {
        $searchRules = [
            'element'    => $field['element']['params'],
            'validation' => $field['validation'],
        ];
        if (!isset($field) || !isset($field['validation']) || !isset($field['element']['params'])) {
            ExceptionServiceFacade::throwError('field_is_null');
        }
        if ($key === 'element') {
            foreach ($field['element']['params'] as $key1 => $val1) {
                if ($key1 === $what) {
                    return $val1;
                }
            }
        }
        foreach ($searchRules[$key] as $find) {
            if (isset($field['rule']) && $field['rule'] === $what) {
                return $field['params'];
            }
        }

        return [];
    }

}


