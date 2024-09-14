<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

use App\Gateway\Contracts\Schema\ActionInterface;

interface ReqRespFactoryInterface
{
    public function makeRequestFromParams(
        ActionInterface $action,
        string $uri,
        array|string|null $body,
        array $headers,
        array $params
    ): RequestInterface;

    public function makeInitialResponse(): ResponseInterface;
}
