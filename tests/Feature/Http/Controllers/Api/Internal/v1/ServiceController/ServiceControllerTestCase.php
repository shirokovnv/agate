<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ServiceController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceControllerTestCase extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/internal/v1/services';

    protected string $existingNameId = 'json-api';

    protected string $nonExistingNameId = 'some id';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
}
