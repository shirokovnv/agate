<?php

declare(strict_types=1);

namespace App\Gateway\Routing;

use App\Gateway\Contracts\Routing\PatternMatcherInterface;
use Illuminate\Support\Str;

class PatternMatcher implements PatternMatcherInterface
{
    public function matchWithPath(string $pattern, string $path): array
    {
        $regex = preg_replace('/\{(\w+)\}/', '(\w+)', $pattern);
        $regex = preg_replace('/\/\*/', '[\w\/]*', $regex);
        $regex = "#^{$regex}$#";

        if (! Str::startsWith($path, '/')) {
            $path = '/'.$path;
        }

        $params = [];

        if (preg_match($regex, $path, $matches)) {
            // Deleting the first element of the array, since it contains the full URI
            array_shift($matches);

            // Get the names of the parameters from the router template
            preg_match_all('/\{(\w+)\}/', $pattern, $paramNames);
            $paramNames = $paramNames[1];

            // Combine the names of the parameters with their values
            $params = array_combine($paramNames, $matches);

            return [true, $params];
        }

        return [false, $params];
    }
}
