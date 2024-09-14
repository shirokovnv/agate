<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema;

use App\Gateway\Contracts\Schema\Workflow\WorkflowInterface;

interface ActionInterface
{
    public function getName(): string;

    public function getMethod(): string;

    public function getPattern(): string;

    public function getPriority(): int;

    /**
     * @return array<WorkflowInterface>
     */
    public function getWorkflows(): array;
}
