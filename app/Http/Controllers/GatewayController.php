<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Gateway\Contracts\Routing\MatchResult;
use App\Gateway\Contracts\Routing\ReqRespFactoryInterface;
use App\Gateway\Contracts\Routing\RouterInterface;
use App\Http\Requests\GatewayRequest;
use Illuminate\Http\JsonResponse;

class GatewayController extends Controller
{
    public function handle(
        GatewayRequest $request,
        RouterInterface $router,
        ReqRespFactoryInterface $reqRespFactory
    ): JsonResponse {
        /** @var MatchResult|null $matchResult */
        $matchResult = $router->match($request->method(), $request->path());

        if ($matchResult !== null) {
            $gatewayRequest = $reqRespFactory->makeRequestFromParams(
                $matchResult->getAction(),
                $request->path(),
                $request->validated(),
                $request->header(),
                $matchResult->getParams()
            );

            $gatewayResponse = $router->handle($gatewayRequest);
            $output = $gatewayResponse->getOutput();
            $gatewayResponse->flush();

            return new JsonResponse($output, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return new JsonResponse(['message' => 'Not found'], 404);
    }
}
