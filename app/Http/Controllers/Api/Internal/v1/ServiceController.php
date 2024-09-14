<?php

namespace App\Http\Controllers\Api\Internal\v1;

use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Internal\v1\ServiceRequest;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceRegistryInterface $serviceRegistry): JsonResponse
    {
        return new JsonResponse($serviceRegistry->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request, ServiceRegistryInterface $serviceRegistry): JsonResponse
    {
        $service = $serviceRegistry->store($request->getName(), $request->getServiceBaseUrl());

        return new JsonResponse($service);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nameId, ServiceRegistryInterface $serviceRegistry): JsonResponse
    {
        $service = $serviceRegistry->findByName($nameId);

        return new JsonResponse($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $nameId, ServiceRequest $request, ServiceRegistryInterface $serviceRegistry): JsonResponse
    {
        $serviceRegistry->update($nameId, $request->getName(), $request->getServiceBaseUrl());

        return new JsonResponse(['status' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nameId, ServiceRegistryInterface $serviceRegistry): JsonResponse
    {
        $serviceRegistry->destroy($nameId);

        return new JsonResponse(['status' => 'deleted']);
    }
}
