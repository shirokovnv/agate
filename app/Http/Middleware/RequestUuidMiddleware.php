<?php

namespace App\Http\Middleware;

use App\Gateway\Contracts\UuidFactoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestUuidMiddleware
{
    public function __construct(private readonly UuidFactoryInterface $uuidFactory) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('X-Request-UUID', $this->uuidFactory->makeUuid());

        return $next($request);
    }
}
