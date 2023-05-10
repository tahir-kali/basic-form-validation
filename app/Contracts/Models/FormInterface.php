<?php

// app/Contracts/Models/FormInterface.php
namespace App\Contracts\Models;

interface FormInterface
{
    public function getFormFields(int $formIndex): array;
}
