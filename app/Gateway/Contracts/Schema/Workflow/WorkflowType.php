<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Workflow;

use Illuminate\Validation\ValidationException;

enum WorkflowType: string
{
    case Parallel = 'parallel';
    case Sequential = 'sequential';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @throws ValidationException
     */
    public static function unsafeConvertFromString(string $value): WorkflowType
    {
        try {
            return WorkflowType::from($value);
        } catch (\ValueError $error) {
            $message = sprintf('Workflow type must be in [%s].', implode(',', self::values()));
            throw ValidationException::withMessages(['workflow_type' => $message]);
        }
    }
}
