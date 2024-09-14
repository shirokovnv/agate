<?php

declare(strict_types=1);

namespace App\Gateway\Schema\Validation;

use App\Gateway\Contracts\Schema\Validation\ValidationResult;
use App\Gateway\Contracts\Schema\Validation\ValidationWrapperInterface;
use JsonSchema\Validator;

class ValidationWrapper implements ValidationWrapperInterface
{
    public function __construct(private readonly Validator $validator) {}

    public function validateJsonSchema(object|array $value, array $schema): ValidationResult
    {
        $this->validator->validate($value, $schema);

        return new ValidationResult($this->validator->isValid(), $this->validator->getErrors());
    }
}
