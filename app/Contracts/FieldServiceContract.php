<?php

namespace App\Contracts;

use Illuminate\Contracts\Validation\ValidationRule;

interface FieldServiceContract
{
    public static function failsToConvertToDataType(mixed $value, string $type): bool;
    public static function getCustomValidationArray(array $field): array;

    public static function validateFieldMetaData(array $field): bool;
    public static function returnTypeRule(array $field): ValidationRule;
}
