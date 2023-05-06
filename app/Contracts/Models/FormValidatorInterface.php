<?php

namespace App\Contracts\Models;

interface FormValidatorInterface
{
    public function execute(int $formId): array;
    public function articulateValidations(): array;
}
