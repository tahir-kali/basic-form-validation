<?php

namespace App\Services;

use App\Contracts\FieldServiceContract;
use App\Facades\FieldServiceFacade;
use App\Rules\ArrayRule;
use App\Rules\InRule;
use App\Rules\LocationRule;
use App\Rules\MaxFileSizeRule;
use App\Rules\MaxRule;
use App\Rules\MediaRule;
use App\Rules\MinRule;
use App\Rules\NullableRule;
use App\Rules\NumberRule;
use App\Rules\RangeRule;
use App\Rules\RequiredRule;
use App\Rules\StringRule;
use Faker\Core\Number;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

final class FieldService implements FieldServiceContract
{


    public static function failsToConvertToDataType(mixed $value, string $type): bool
    {
        $dataTypeConversionArray = [
            'string' => strval($value),
            'integer' => intval($value)
        ];

        return $dataTypeConversionArray[$type] === null;

    }

    public static function getValuesCSV(array $field): array
    {
        return data_get($field, 'values.*.value');
    }

    public static function validateFieldMetaData(array $field): bool
    {
        $keysToExist = ['id', 'data_type', 'validation'];
        if (Arr::has($field, $keysToExist)) {
            return true;
        } else {
            return false;
        }

    }

    public static function getCustomValidationRule(array $field, ?string $rule = null): ValidationRule
    {
        if (!$rule) {
            return FieldServiceFacade::returnTypeRule($field);
        }
        if (isset(FieldServiceFacade::getCustomValidationArray($field)[$rule])) {
            return FieldServiceFacade::getCustomValidationArray($field)[$rule];
        }
        if (isset(FieldServiceFacade::getDataTypeRules($field)[$rule])) {
            return FieldServiceFacade::getDataTypeRules($field)[$rule];
        }
        if (isset(FieldServiceFacade::getSpecialRules($field)[$rule])) {
            return FieldServiceFacade::getSpecialRules($field)[$rule];
        }

        return new NullableRule($field);
    }

//    Rules Start

    public static function getCustomValidationArray(array $field): array
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

    public static function getDataTypeRules(array $field): array
    {
        return [
            'string'  => new StringRule($field),
            'integer' => new NumberRule($field),
            'array'   => new ArrayRule($field),
        ];
    }

    public static function getSpecialRules(array $field): array
    {
        return [
            'location'      => new LocationRule($field),
            'max_file_size' => new MaxFileSizeRule($field),
            'images'        => new MediaRule('image'),
            'required'      => new RequiredRule($field),
            'in'            => new InRule($field),
        ];
    }

    public static function returnTypeRule(array $field): ValidationRule
    {
        $data_type_rules = FieldService::getDataTypeRules($field);
        $data_type       = gettype($field['values'][0]['value']);
        return $data_type_rules[$data_type];
    }

//    Rules End

    public static function extractValidationRules(array $field): array
    {
        $validation_arr    = [];
        $validationClasses = FieldServiceFacade::getCustomValidationArray($field);
        foreach ($field['validation'] as $validation) {
            $rule = $validation['rule']; // required, min, max
            if (isset($validationClasses[$rule])) {
                $validation_arr[] = $validationClasses[$rule];
            }
        }
        return $validation_arr;
    }

    public static function articulateErrorMessageForField(array $field): array
    {
        $messages = [];

        if(isset($field['validation'])){
            foreach ($field['validation'] as $validation) {
                $messages[$validation['rule']] = $validation['message'];
            }
        }else{
            dd($field);
        }

        return $messages;

    }

    public static function returnAdditionalFieldProperties(array $field): array
    {
        $resultArr        = [
            'child_validations' => []
        ];
        $keys_to_ignore   = ['min', 'max', 'size', 'multiple'];
        $child_properties = FieldServiceFacade::getSpecialRules($field);
        foreach (data_get($field, 'element.params') as $key => $value) {
            if (in_array($key, $keys_to_ignore) || gettype($value) === 'array') {
                continue;
            }
            if (in_array($key, $child_properties)) {
                $resultArr['child_validations'][] = $child_properties[$key];
            }
        }
        if (count($field['values'])) {
            $resultArr['child_validations'][] = FieldServiceFacade::getCustomValidationRule($field);
            $resultArr['child_validations'][] = FieldServiceFacade::getCustomValidationRule($field, 'in');
        }
        //extract special keys here
        if ($field['slug'] == 'images') {
            $resultArr['child_validations'][] = FieldServiceFacade::getCustomValidationRule($field, 'images');
        }

        return $resultArr;
    }

    public static function extractErrorMessageFromFieldObject(array $field, string $rule): string
    {
        $errorMessages = [
            'string' => 'This field accepts only string values',
            'array'  => 'This field accepts only arrays',
            'number' => 'This field accepts only numbers',
            ...FieldServiceFacade::articulateErrorMessageForField($field)
        ];
        if (isset($errorMessages[$rule])) {
            return $errorMessages[$rule];
        }

        return 'No Custome error Message found extractErrorMessageFromFieldObject' . $rule;
    }

}


