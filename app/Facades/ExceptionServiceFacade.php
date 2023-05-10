<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static throwError(string $string)
 */
final class ExceptionServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'exceptionService';
    }
}
