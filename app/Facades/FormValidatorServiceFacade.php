<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static throwError(string $string)
 * @method static execute(int $formId)
 */
final class FormValidatorServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'formValidatorService';
    }
}
