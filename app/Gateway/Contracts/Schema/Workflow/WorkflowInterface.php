<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Workflow;

interface WorkflowInterface
{
    /**
     * @return array<StepInterface>
     */
    public function getSteps(): array;

    public function getType(): WorkflowType;
}
