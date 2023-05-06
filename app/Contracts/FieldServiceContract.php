<?php

namespace App\Contracts;

use Illuminate\Contracts\Validation\ValidationRule;

interface FieldServiceContract
{
    public static function failsToConvertToDataType(mixed $value, string $type): bool;
    public static function getCustomValidationArray(array $field): array;

    public static function validateFieldMetaData(array $field): bool;
    public static function returnTypeRule(array $field): ValidationRule;
    public static function extractValidationRules(array $field): array;
    public static function returnAdditionalFieldProperties(array $field): array;
    public static function getCustomValidationRule(array $field, ?string $rule): ValidationRule;
    public static function getSpecialRules(array $field): array;
    public static function extractErrorMessageFromFieldObject(array $field, string $rule): string;
    public static function articulateErrorMessageForField(array $field): array;
}
