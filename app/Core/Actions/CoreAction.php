<?php

namespace App\Core\Actions;

use App\Core\Contracts\Action;
use App\Exceptions\MethodNotImplementedException;
use Throwable;

abstract class CoreAction implements Action
{
    public function execute(...$params)
    {
        try {
            if (!method_exists($this, 'handle')) {
                throw new MethodNotImplementedException('Method "handle" does not exist in: ' . get_class($this));
            }

            $result = $this->handle(...$params);
        } catch (Throwable $e) {
            $this->processFailure($e);
        }
        return $result;
    }
    private function processFailure(Throwable $e)
    {
        throw $e;
    }
}
