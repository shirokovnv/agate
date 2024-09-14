<?php

declare(strict_types=1);

namespace App\Gateway\Worker;

use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Gateway\Contracts\Schema\Workflow\WorkflowType;
use App\Gateway\Contracts\Worker\WorkerFactoryInterface;
use App\Gateway\Contracts\Worker\WorkerInterface;
use Illuminate\Http\Client\Factory;
use Psr\Log\LoggerInterface;

final class WorkerFactory implements WorkerFactoryInterface
{
    public function __construct(
        private readonly Factory $factory,
        private readonly ServiceRegistryInterface $serviceRepo,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws \Exception
     */
    public function create(WorkflowType $type): WorkerInterface
    {
        if ($type === WorkflowType::Parallel) {
            return new ParallelWorker($this->serviceRepo, $this->factory, $this->logger);
        }

        if ($type === WorkflowType::Sequential) {
            return new SequentialWorker($this->serviceRepo, $this->factory, $this->logger);
        }

        throw new \Exception('Wrong workflow type.');
    }
}
