<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ActionController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ActionControllerTestCase extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/internal/v1/actions';

    protected string $existingNameId = 'api.v1.json_api.collect';

    protected string $nonExistingNameId = 'some id';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
}
