<?php

declare(strict_types=1);

namespace App\Gateway\Schema\Registry;

use App\Gateway\Contracts\Schema\ActionInterface;
use App\Gateway\Contracts\Schema\Registry\ActionRegistryInterface;
use App\Models\Action;

class ActionRegistry implements ActionRegistryInterface
{
    /**
     * @return array|ActionInterface[]
     */
    public function get(array $filters = []): array
    {
        return Action::query()
            ->where($filters)
            ->orderBy('priority', 'desc')
            ->get()
            ->all();
    }

    public function store(string $name, string $method, string $pattern, int $priority = 0, array $workflows = []): ActionInterface
    {
        return Action::query()
            ->create(
                [
                    'name' => $name,
                    'method' => $method,
                    'pattern' => $pattern,
                    'priority' => $priority,
                    'workflows' => $workflows,
                ]
            );
    }

    public function update(string $nameId, ?string $name = null, ?string $method = null, ?string $pattern = null, int $priority = 0, array $workflows = []): void
    {
        /** @var Action $action */
        $action = Action::query()
            ->where('name', '=', $nameId)
            ->firstOrFail();

        $action->update(
            array_filter([
                'name' => $name,
                'method' => $method,
                'pattern' => $pattern,
                'priority' => $priority,
                'workflows' => $workflows,
            ])
        );
    }

    public function destroy(string $nameId): void
    {
        /** @var Action $action */
        $action = Action::query()
            ->where('name', '=', $nameId)
            ->firstOrFail();

        $action->delete();
    }

    public function findByName(string $name): ActionInterface
    {
        return Action::query()
            ->where('name', '=', $name)
            ->firstOrFail();
    }
}
