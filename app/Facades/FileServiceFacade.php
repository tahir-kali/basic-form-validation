<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static toArray(string $string)
 */
final class FileServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fileService';
    }
}
