<?php

declare(strict_types=1);

namespace App\Observers;

use App\Gateway\Contracts\Schema\Validation\ValidationWrapperInterface;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class JsonSchemaObserver
{
    public function __construct(
        private readonly ConfigRepository $config,
        private readonly ValidationWrapperInterface $validationWrapper
    ) {}

    public function saving(Model $model): void
    {
        /** @var string $schema_path */
        $schema_path = $this->config->get('gateway.schema.'.get_class($model));
        $schema = json_decode(file_get_contents($schema_path), true);

        $object = json_decode(json_encode($model->toArray()));

        $validationResult = $this->validationWrapper->validateJsonSchema($object, $schema);

        if (! $validationResult->isValid()) {
            throw ValidationException::withMessages($validationResult->getErrors());
        }
    }
}
