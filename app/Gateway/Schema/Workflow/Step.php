<?php

declare(strict_types=1);

namespace App\Gateway\Schema\Workflow;

use App\Gateway\Contracts\Schema\Workflow\StepInterface;

final class Step implements \JsonSerializable, StepInterface
{
    public function __construct(
        private readonly string $method,
        private readonly string $service,
        private readonly string $path,
        private readonly ?string $outKey
    ) {}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getOutKey(): ?string
    {
        return $this->outKey;
    }

    public function jsonSerialize(): array
    {
        return [
            'method' => $this->getMethod(),
            'service' => $this->getService(),
            'path' => $this->getPath(),
            'out_key' => $this->getOutKey(),
        ];
    }
}
