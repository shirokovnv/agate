<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Registry;

use App\Gateway\Contracts\Schema\ServiceInterface;

interface ServiceRegistryInterface
{
    /**
     * @return array<ServiceInterface>
     */
    public function get(): array;

    public function findByName(string $name): ServiceInterface;

    public function store(string $name, string $baseUrl): ServiceInterface;

    public function update(string $nameId, ?string $name = null, ?string $baseUrl = null): void;

    public function destroy(string $nameId): void;
}
