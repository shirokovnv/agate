<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Worker;

use App\Gateway\Contracts\Routing\RequestInterface;
use App\Gateway\Contracts\Routing\ResponseInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowInterface;

interface WorkerInterface
{
    public function run(WorkflowInterface $workflow, RequestInterface $request, ResponseInterface $response): void;
}
