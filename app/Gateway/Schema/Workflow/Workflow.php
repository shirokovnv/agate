<?php

declare(strict_types=1);

namespace App\Gateway\Schema\Workflow;

use App\Gateway\Contracts\Schema\Workflow\StepInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowType;

final class Workflow implements \JsonSerializable, WorkflowInterface
{
    /**
     * @param  array<StepInterface>  $steps
     */
    public function __construct(
        private readonly array $steps,
        private readonly WorkflowType $type
    ) {}

    /**
     * @return StepInterface[]
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function getType(): WorkflowType
    {
        return $this->type;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'steps' => $this->getSteps(),
        ];
    }
}
