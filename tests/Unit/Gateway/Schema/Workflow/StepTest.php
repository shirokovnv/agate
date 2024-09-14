<?php

declare(strict_types=1);

namespace Tests\Unit\Gateway\Schema\Workflow;

use App\Gateway\Schema\Workflow\Step;
use Tests\TestCase;

class StepTest extends TestCase
{
    public function testDataSerialization(): void
    {
        $step = new Step(
            $method = 'GET',
            $service = 'service',
            $path = '/path',
            $outKey = 'out'
        );

        $this->assertSame($method, $step->getMethod());
        $this->assertSame($service, $step->getService());
        $this->assertSame($path, $step->getPath());
        $this->assertSame($outKey, $step->getOutKey());

        $this->assertJson(json_encode($step));
    }
}
