<?php

// app/Contracts/Models/FormInterface.php
namespace App\Contracts\Models;

interface FormInterface
{
    public function getFormMetaData(int $formIndex): array;
}
