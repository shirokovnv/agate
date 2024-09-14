<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForwardHeadersMiddleware
{
    public function __construct(private readonly ConfigRepository $config) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var array $allowedHeaders */
        $allowedHeaders = $this->config->get('gateway.options.allowed_headers');

        $request->headers->replace($this->forwardHeaders($request->header(), $allowedHeaders));

        return $next($request);
    }

    private function forwardHeaders(array $originalHeaders, array $allowedHeaders = ['*']): array
    {
        if (in_array('*', $allowedHeaders)) {
            return $originalHeaders;
        }

        return array_filter(
            $originalHeaders,
            fn ($key) => in_array($key, array_map('strtolower', $allowedHeaders)),
            ARRAY_FILTER_USE_KEY
        );
    }
}
