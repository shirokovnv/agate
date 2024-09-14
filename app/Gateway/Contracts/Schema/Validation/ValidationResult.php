<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Validation;

final class ValidationResult
{
    public function __construct(private readonly bool $isValid, private readonly array $errors) {}

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}
