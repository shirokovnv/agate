<?php

declare(strict_types=1);

namespace App\Gateway\Routing;

use App\Gateway\Contracts\Routing\ResponseInterface;

class Response implements ResponseInterface
{
    private array $data = [];

    public function getOutput(): array
    {
        return $this->data;
    }

    public function getByKey(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function collect(string $key, mixed $value)
    {
        $this->data[$key] = $value;
    }

    public function flush(): void
    {
        $this->data = [];
    }
}
