<?php

namespace App\Services;

use App\Abstracts\AbstractFieldServiceClass;
use App\Facades\ExceptionServiceFacade;
use JetBrains\PhpStorm\NoReturn;

final class ExceptionService extends AbstractFieldServiceClass
{
    #[NoReturn] public function throwError(string $errorName): void
    {
        // TODO: Implement throwError() method.

        trigger_error([...ExceptionServiceFacade::$exceptions[$errorName]]);

    }

}


