<?php

namespace App\Http\Controllers\Api\Internal\v1;

use App\Gateway\Contracts\Schema\Registry\ActionRegistryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Internal\v1\ActionRequest;
use Illuminate\Http\JsonResponse;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ActionRegistryInterface $actionRegistry): JsonResponse
    {
        return new JsonResponse($actionRegistry->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActionRequest $request, ActionRegistryInterface $actionRegistry): JsonResponse
    {
        $action = $actionRegistry->store(
            $request->getName(),
            $request->getActionMethod(),
            $request->getPattern(),
            $request->getPriority(),
            $request->getWorkflows()
        );

        return new JsonResponse($action);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nameId, ActionRegistryInterface $actionRegistry): JsonResponse
    {
        $action = $actionRegistry->findByName($nameId);

        return new JsonResponse($action);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $nameId, ActionRequest $request, ActionRegistryInterface $actionRegistry): JsonResponse
    {
        $actionRegistry->update(
            $nameId,
            $request->getName(),
            $request->getActionMethod(),
            $request->getPattern(),
            $request->getPriority(),
            $request->getWorkflows()
        );

        return new JsonResponse(['status' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nameId, ActionRegistryInterface $actionRegistry): JsonResponse
    {
        $actionRegistry->destroy($nameId);

        return new JsonResponse(['status' => 'deleted']);
    }
}
