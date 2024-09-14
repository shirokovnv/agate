<?php

declare(strict_types=1);

namespace App\Gateway\Routing;

use App\Gateway\Contracts\Routing\ReqRespFactoryInterface;
use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Schema\ActionInterface;

final class ReqRespFactory implements ReqRespFactoryInterface
{
    public function makeRequestFromParams(
        ActionInterface $action,
        string $uri,
        array|string|null $body,
        array $headers,
        array $params
    ): RequestInterface {
        $jsonBody = match (true) {
            is_array($body) => $body,
            is_string($body) => (array) json_decode($body, true),
            is_null($body()) => []
        };

        return new Request(
            $action,
            $uri,
            $jsonBody,
            $headers,
            $params
        );
    }

    public function makeInitialResponse(): ResponseInterface
    {
        return new Response;
    }
}
