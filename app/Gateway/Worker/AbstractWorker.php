<?php

declare(strict_types=1);

namespace App\Gateway\Worker;

use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Gateway\Contracts\Schema\ServiceInterface;
use App\Gateway\Contracts\Worker\WorkerInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Arr;
use Psr\Log\LoggerInterface;

abstract class AbstractWorker implements WorkerInterface
{
    public function __construct(
        protected readonly ServiceRegistryInterface $serviceRegistry,
        protected readonly Factory $clientFactory,
        protected readonly LoggerInterface $logger
    ) {}

    /**
     * @return array<string, string>
     */
    protected function getServicesAsKeyValuePairs(): array
    {
        return collect($this->serviceRegistry->get())
            ->mapWithKeys(function (ServiceInterface $service) {
                return [$service->getName() => $service->getBaseUrl()];
            })->toArray();
    }

    protected function replaceParameters(
        string $uri,
        array $uriParams,
        array $bodyParams
    ): string {
        $pattern = '/(\{(\w+)\})|(\$([a-zA-Z0-9_]+)\.([\w.]+))/';

        return preg_replace_callback($pattern, function ($matches) use ($uriParams, $bodyParams) {

            if (! empty($matches[2])) {
                $paramName = $matches[2];

                return $uriParams[$paramName] ?? $matches[0];
            } elseif (! empty($matches[4] && ! empty($matches[5]))) {
                $rootKey = $matches[4];
                $replacements = $bodyParams[$rootKey] ?? [];
                $paramName = $matches[5];

                return Arr::get($replacements, $paramName, $matches[0]);
            }

            return $matches[0];
        }, $uri);
    }

    protected function collectBodyParams(RequestInterface $request, ResponseInterface $response): array
    {
        return [
            'req' => $request->getBody(),
            'resp' => $response->getOutput(),
        ];
    }

    protected function withLoggerMiddleware(): Factory
    {
        return $this->clientFactory
            ->globalMiddleware(function ($handler) {
                return function ($request, $options) use ($handler) {
                    $startedAt = now();
                    $this->logger->info($request->getUri());

                    return $handler($request, $options)
                        ->then(function (Response $response) use ($startedAt) {
                            $this->logger->info($response->getStatusCode());

                            return $response->withHeader(
                                'X-Duration',
                                $startedAt->diffInMilliseconds(now())
                            );
                        });
                };
            });
    }
}
