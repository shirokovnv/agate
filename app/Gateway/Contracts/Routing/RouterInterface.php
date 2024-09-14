<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

interface RouterInterface
{
    public function match(string $method, string $path): ?MatchResult;

    public function handle(RequestInterface $request): ResponseInterface;
}
