<?php

declare(strict_types=1);

namespace App\Gateway\Worker;

use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowInterface;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;

final class ParallelWorker extends AbstractWorker
{
    public function run(
        WorkflowInterface $workflow,
        RequestInterface $request,
        ResponseInterface $response
    ): void {
        $steps = $workflow->getSteps();
        $services = $this->getServicesAsKeyValuePairs();

        $this->withLoggerMiddleware()->pool(function (Pool $pool) use ($steps, $services, $request, $response) {
            $result = [];

            foreach ($steps as $step) {
                $serviceKey = $step->getService();
                $outKey = $step->getOutKey();
                $baseUrl = $services[$serviceKey] ?? null;

                if ($baseUrl === null) {
                    continue;
                }

                $path = $this->replaceParameters(
                    $step->getPath(),
                    $request->getParams(),
                    $this->collectBodyParams($request, $response)
                );

                $result[] = $pool
                    ->baseUrl($baseUrl)
                    ->withBody(json_encode($request->getBody()))
                    ->withHeaders($request->getHeaders())
                    ->send($step->getMethod(), $path)
                    ->then(function (Response|TransferException $httpResponse) use ($outKey, $response) {
                        $data = json_decode($httpResponse->getBody()->getContents(), true);
                        $response->collect($outKey, $data);
                    });
            }

            return $result;
        });
    }
}
