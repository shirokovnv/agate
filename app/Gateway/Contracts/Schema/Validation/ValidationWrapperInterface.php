<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Validation;

interface ValidationWrapperInterface
{
    public function validateJsonSchema(object|array $value, array $schema): ValidationResult;
}
