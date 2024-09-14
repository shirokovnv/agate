<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

use App\Gateway\Contracts\Schema\ActionInterface;

final class MatchResult
{
    public function __construct(
        private readonly ActionInterface $action,
        private readonly array $params
    ) {}

    public function getAction(): ActionInterface
    {
        return $this->action;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
