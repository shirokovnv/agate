<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Registry;

use App\Gateway\Contracts\Schema\ActionInterface;

interface ActionRegistryInterface
{
    /**
     * @return array<ActionInterface>
     */
    public function get(array $filters = []): array;

    public function findByName(string $name): ActionInterface;

    public function store(
        string $name,
        string $method,
        string $pattern,
        int $priority = 0,
        array $workflows = []
    ): ActionInterface;

    public function update(
        string $nameId,
        ?string $name = null,
        ?string $method = null,
        ?string $pattern = null,
        int $priority = 0,
        array $workflows = []
    ): void;

    public function destroy(string $nameId): void;
}
