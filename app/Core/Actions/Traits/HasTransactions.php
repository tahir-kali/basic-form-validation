<?php

namespace App\Core\Actions\Traits;

use Illuminate\Database\DatabaseManager;

trait HasTransactions
{
    protected static $transactionOwner = null;

    protected function getDatabaseManager(): DatabaseManager
    {
        return app(DatabaseManager::class);
    }

    protected function beginTransaction()
    {
        if ($this->hasLock()) {
            return;
        }
        $this->lock();
        $this->getDatabaseManager()->beginTransaction();
    }

    protected function commit()
    {
        if ($this->isTransactionOwner()) {
            $this->getDatabaseManager()->commit();
            $this->unlock();
        }
    }

    protected function rollBack()
    {
        if ($this->isTransactionOwner()) {
            $this->getDatabaseManager()->rollBack();
            $this->unlock();
        }
    }

    protected function hasLock(): bool
    {
        return !is_null(self::$transactionOwner);
    }

    protected function lock()
    {
        self::$transactionOwner = spl_object_hash($this);
    }

    protected function unlock()
    {
        self::$transactionOwner = null;
    }

    protected function isTransactionOwner()
    {
        return self::$transactionOwner === spl_object_hash($this);
    }

    protected function beforeRollBack()
    {
    }

    protected function beforeCommit()
    {
    }

    protected function afterCommit(...$params)
    {
    }
}
