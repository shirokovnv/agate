<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Worker;

use App\Gateway\Contracts\Schema\Workflow\WorkflowType;

interface WorkerFactoryInterface
{
    public function create(WorkflowType $type): WorkerInterface;
}
