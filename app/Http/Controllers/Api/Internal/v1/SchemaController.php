<?php

namespace App\Http\Controllers\Api\Internal\v1;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Service;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\JsonResponse;

class SchemaController extends Controller
{
    public function introspectActionSchema(ConfigRepository $config): JsonResponse
    {
        $schema = json_decode(
            file_get_contents($config->get('gateway.schema.'.Action::class)),
            true
        );

        return new JsonResponse($schema, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function introspectServiceSchema(ConfigRepository $config): JsonResponse
    {
        $schema = json_decode(
            file_get_contents($config->get('gateway.schema.'.Service::class)),
            true
        );

        return new JsonResponse($schema, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
