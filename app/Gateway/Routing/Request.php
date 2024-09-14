<?php

declare(strict_types=1);

namespace App\Gateway\Routing;

use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Schema\ActionInterface;

class Request implements RequestInterface
{
    public function __construct(
        private readonly ActionInterface $action,
        private readonly string $uri,
        private readonly array $body = [],
        private readonly array $headers = [],
        private readonly array $params = []
    ) {}

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getAction(): ActionInterface
    {
        return $this->action;
    }
}
