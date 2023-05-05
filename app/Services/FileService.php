<?php

namespace App\Services;

use App\Contracts\FileServiceContract;

final class FileService implements FileServiceContract
{
    public function toArray(string $path): array {
        return convertFileToArray($path);
    }

}


