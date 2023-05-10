<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static sendLogs(array $data)
 * @method static makePostRequest(string $string, false|string $body)
 */
final class LogServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logService';
    }
}
