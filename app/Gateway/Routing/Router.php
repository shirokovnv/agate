<?php

declare(strict_types=1);

namespace App\Gateway\Routing;

use App\Gateway\Contracts\Routing\MatchResult;
use App\Gateway\Contracts\Routing\PatternMatcherInterface;
use App\Gateway\Contracts\Routing\ReqRespFactoryInterface;
use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Routing\RouterInterface;
use App\Gateway\Contracts\Schema\Registry\ActionRegistryInterface;
use App\Gateway\Contracts\Worker\WorkerFactoryInterface;

class Router implements RouterInterface
{
    public function __construct(
        private readonly ActionRegistryInterface $actionRegistry,
        private readonly ReqRespFactoryInterface $reqRespFactory,
        private readonly WorkerFactoryInterface $workerFactory,
        private readonly PatternMatcherInterface $patternMatcher
    ) {}

    public function match(string $method, string $path): ?MatchResult
    {
        $actions = $this->actionRegistry->get(['method' => strtolower($method)]);
        foreach ($actions as $action) {
            [$match, $params] = $this->patternMatcher->matchWithPath($action->getPattern(), $path);

            if ($match) {
                return new MatchResult($action, $params);
            }
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $workflows = $request->getAction()->getWorkflows();

        $response = $this->reqRespFactory->makeInitialResponse();
        foreach ($workflows as $workflow) {
            $worker = $this->workerFactory->create($workflow->getType());
            $worker->run($workflow, $request, $response);
        }

        return $response;
    }
}
