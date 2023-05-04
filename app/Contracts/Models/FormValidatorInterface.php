<?php

namespace App\Contracts\Models;

interface FormValidatorInterface
{
    public function execute(): array;

    public function validateFieldMetaData(array $field): void;

    public function articulateValidations(): array;

    public function extractFieldProperties(array $field): array;
}
