<?php

declare(strict_types=1);

namespace App\Gateway\Worker;

use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowInterface;
use Illuminate\Http\Client\ConnectionException;

final class SequentialWorker extends AbstractWorker
{
    /**
     * @throws ConnectionException
     */
    public function run(
        WorkflowInterface $workflow,
        RequestInterface $request,
        ResponseInterface $response
    ): void {
        $steps = $workflow->getSteps();
        $services = $this->getServicesAsKeyValuePairs();

        $httpClient = $this->withLoggerMiddleware();

        foreach ($steps as $step) {
            $baseUrl = $services[$step->getService()] ?? null;

            if ($baseUrl === null) {
                continue;
            }

            $path = $this->replaceParameters(
                $step->getPath(),
                $request->getParams(),
                $this->collectBodyParams($request, $response)
            );

            $httpResponse = $httpClient
                ->baseUrl($baseUrl)
                ->withBody(json_encode($request->getBody()))
                ->withHeaders($request->getHeaders())
                ->send($step->getMethod(), $path);

            $data = json_decode($httpResponse->getBody()->getContents(), true);

            $response->collect($step->getOutKey(), $data);
        }
    }
}
