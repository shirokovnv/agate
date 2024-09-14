<?php

declare(strict_types=1);

namespace App\Models\Casts;

use App\Gateway\Contracts\Schema\Workflow\WorkflowType;
use App\Gateway\Schema\Workflow\Step;
use App\Gateway\Schema\Workflow\Workflow;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

final class WorkflowJsonCast implements CastsAttributes
{
    /**
     * @return mixed|null
     *
     * @throws ValidationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $decodedJson = json_decode($value, true);

        return array_map(function ($rawWorkflow) {
            $steps = array_map(function ($rawStep) {
                return new Step(
                    $rawStep['method'] ?? 'GET',
                    $rawStep['service'] ?? '',
                    $rawStep['path'] ?? '',
                    $rawStep['out_key'] ?? ''
                );
            }, $rawWorkflow['steps'] ?? []);

            return new Workflow($steps, WorkflowType::unsafeConvertFromString($rawWorkflow['type'] ?? ''));
        }, $decodedJson);
    }

    /**
     * @return false|string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): bool|string
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
