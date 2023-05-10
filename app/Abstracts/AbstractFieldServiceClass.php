<?php

namespace App\Abstracts;

abstract class AbstractFieldServiceClass
{
    public static array $exceptions = [
        'invalid_meta_data'    => ['Invalid metadata', E_USER_ERROR],
        'field_is_null'        => ['Field is null', E_USER_ERROR],
        'validation_not_found' => ['Field validation not found', E_USER_ERROR],
    ];

    abstract public function throwError(string $errorName);
}