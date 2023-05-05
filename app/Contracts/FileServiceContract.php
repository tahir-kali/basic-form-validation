<?php

namespace App\Contracts;

interface FileServiceContract{
    public function toArray(string $path): array;
}
