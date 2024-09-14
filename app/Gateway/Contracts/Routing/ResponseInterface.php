<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

interface ResponseInterface
{
    public function getOutput(): array;

    public function getByKey(string $key, mixed $default = null): mixed;

    public function collect(string $key, mixed $value);

    public function flush(): void;
}
