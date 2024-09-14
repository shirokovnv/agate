<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

use App\Gateway\Contracts\Schema\ActionInterface;

interface RequestInterface
{
    public function getAction(): ActionInterface;

    public function getUri(): string;

    public function getBody(): array;

    public function getHeaders(): array;

    public function getParams(): array;
}
