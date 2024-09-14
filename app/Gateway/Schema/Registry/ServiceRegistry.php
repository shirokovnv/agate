<?php

declare(strict_types=1);

namespace App\Gateway\Schema\Registry;

use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Gateway\Contracts\Schema\ServiceInterface;
use App\Models\Service;

class ServiceRegistry implements ServiceRegistryInterface
{
    /**
     * @return ServiceInterface[]
     */
    public function get(array $filters = []): array
    {
        return Service::query()
            ->where($filters)
            ->get()
            ->all();
    }

    public function store(string $name, string $baseUrl): ServiceInterface
    {
        return Service::query()
            ->create([
                'name' => $name,
                'base_url' => $baseUrl,
            ]);
    }

    public function update(string $nameId, ?string $name, ?string $baseUrl): void
    {
        /** @var Service $service */
        $service = Service::query()
            ->where('name', '=', $nameId)
            ->firstOrFail();

        $service->update(
            array_filter([
                'name' => $name,
                'base_url' => $baseUrl,
            ])
        );
    }

    public function destroy(string $nameId): void
    {
        /** @var Service $service */
        $service = Service::query()
            ->where('name', '=', $nameId)
            ->firstOrFail();

        $service->delete();
    }

    public function findByName(string $name): ServiceInterface
    {
        return Service::query()
            ->where('name', '=', $name)
            ->firstOrFail();
    }
}
