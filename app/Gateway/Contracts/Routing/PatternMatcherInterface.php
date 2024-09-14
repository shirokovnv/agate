<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Routing;

interface PatternMatcherInterface
{
    /**
     * @return array{bool, array}
     */
    public function matchWithPath(string $pattern, string $path): array;
}
