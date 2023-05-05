<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCustomValidationArray(array $field)
 * @method static validateFieldMetaData(array $field)
 * @method static getDataTypeRules(mixed $field)
 * @method static returnTypeRule(mixed $field)
 * @method static getValuesCSV(mixed $field)
 * @method static convertToOrReturnNull(mixed $value, string $string)
 * @method static failsToConvertToDataType(mixed $value, string $string)
 */
final class FieldServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fieldService';
    }
}
