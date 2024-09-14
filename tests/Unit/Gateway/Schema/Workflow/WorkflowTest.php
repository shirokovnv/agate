<?php

declare(strict_types=1);

namespace Tests\Unit\Gateway\Schema\Workflow;

use App\Gateway\Contracts\Schema\Workflow\WorkflowType;
use App\Gateway\Schema\Workflow\Step;
use App\Gateway\Schema\Workflow\Workflow;
use Tests\TestCase;

class WorkflowTest extends TestCase
{
    public function testDataSerialization(): void
    {
        foreach (WorkflowType::cases() as $workflowType) {
            $workflow = new Workflow(
                $steps = [
                    new Step('GET', 'service', '/test_get', 'out_get'),
                    new Step('POST', 'service', 'test_post', 'out_post'),
                ],
                $workflowType,
            );

            $this->assertSame($workflow->getType(), $workflowType);
            $this->assertSame($steps, $workflow->getSteps());

            $this->assertJson(json_encode($workflow));
        }
    }
}
