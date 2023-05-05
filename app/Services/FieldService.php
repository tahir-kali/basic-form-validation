<?php

namespace App\Services;
use App\Contracts\FieldServiceContract;
use App\Rules\ArrayRule;
use App\Rules\MaxRule;
use App\Rules\MinRule;
use App\Rules\NumberRule;
use App\Rules\RangeRule;
use App\Rules\RequiredRule;
use App\Rules\StringRule;
use Faker\Core\Number;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class FieldService implements FieldServiceContract
{

    public static function failsToConvertToDataType(mixed $value, string $type): bool
    {
        $dataTypeConversionArray = [
            "integer" => intval($value)
        ];
        return $dataTypeConversionArray[$type] === null;

    }
    public static function getValuesCSV(array $field): array
    {
        return data_get($field,"values.*.value");
    }
    public static function getCustomValidationArray(array $field): array
    {
        return [
            "required"  => new RequiredRule($field),
            "min"       => new MinRule($field),
            "max"       => new MaxRule($field),
            "min_value" => new MinRule($field),
            "mix_value" => new MinRule($field),
            "max_value" => new MaxRule($field),
            "range"     => new RangeRule($field)
        ];
    }
    public static function validateFieldMetaData(array $field): bool
    {
        $keysToExist = ["id","data_type", "validation"];
        if (Arr::has($field, $keysToExist)) {
            return true;
        } else {
            return false;
        }

    }
    public static function getDataTypeRules(array $field): array
    {
        return [
            "string"  => new StringRule($field),
            "integer" => new NumberRule($field),
            "array"   => new ArrayRule($field),
        ];
    }
    public static function returnTypeRule(array $field): ValidationRule
    {
        $data_type_rules = FieldService::getDataTypeRules($field);
        $data_type = gettype($field['values'][0]);
        return $data_type_rules[$data_type];
    }

}


