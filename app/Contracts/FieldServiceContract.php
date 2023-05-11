<?php

namespace App\Contracts;

use Illuminate\Contracts\Validation\ValidationRule;

interface FieldServiceContract
{
    public function failsToConvertToDataType(mixed $value, string $type): bool;
    public function getCustomValidationArray(array $field): array;
    public function getValuesCSV(array $field): array;
    public function validateFieldMetaData(array $field): bool;
    public function returnTypeRule(array $field): ValidationRule;
    public function extractValidationRules(array $field): array;
    public function returnAdditionalFieldProperties(array $field): array;
    public function getCustomValidationRule(array $field, ?string $rule): ValidationRule;
    public function getSpecialRules(array $field): array;
    public function extractErrorMessageFromFieldObject(array $field, string $rule): string;
    public function articulateErrorMessageForField(array $field): array;
    public function extractValuesFromFieldParamsOrValidation(array $field, string $key, string $what): mixed;
}
