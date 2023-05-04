<?php

// app/Contracts/Models/FormInterface.php

namespace App\Contracts\Models;

interface FormInterface
{
    public function getFileAndConvertToArray(string $path): array;
    public function getFields(): array;
    public function getFormMetaData(integer $formIndex): array;
}
