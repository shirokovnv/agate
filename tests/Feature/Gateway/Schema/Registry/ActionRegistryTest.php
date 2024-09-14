<?php

declare(strict_types=1);

namespace Tests\Feature\Gateway\Schema\Registry;

use App\Gateway\Contracts\Schema\ActionInterface;
use App\Gateway\Contracts\Schema\Registry\ActionRegistryInterface;
use App\Models\Action;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ActionRegistryTest extends TestCase
{
    use RefreshDatabase;

    protected ActionRegistryInterface $actionRegistry;

    protected function setUp(): void
    {
        parent::setUp();
        Action::query()->truncate();
        $this->actionRegistry = $this->app->make(ActionRegistryInterface::class);
    }

    protected function tearDown(): void
    {
        unset($this->actionRegistry);
        parent::tearDown();
    }

    public function testGet(): void
    {
        $actions = $this->actionRegistry->get();
        $this->assertDatabaseCount('actions', 0);
        $this->assertCount(0, $actions);

        $this->seed();
        $actions = $this->actionRegistry->get();
        $this->assertDatabaseCount('actions', 1);
        $this->assertCount(1, $actions);
        foreach ($actions as $action) {
            $this->assertInstanceOf(ActionInterface::class, $action);
        }
    }

    public function testStore(): void
    {
        $this->assertDatabaseCount('actions', 0);

        $this->actionRegistry->store(
            'api.test',
            'get',
            '/test/{ID}',
            10,
            []
        );

        $this->assertDatabaseCount('actions', 1);

        $action = Action::query()
            ->where('name', 'api.test')
            ->first();

        $this->assertInstanceOf(ActionInterface::class, $action);
    }

    public function testFindByName(): void
    {
        $this->seed();
        $action = $this->actionRegistry->findByName('api.v1.json_api.collect');
        $this->assertInstanceOf(ActionInterface::class, $action);

        $this->expectException(ModelNotFoundException::class);
        $this->actionRegistry->findByName('test-api');
    }

    public function testUpdate(): void
    {
        $this->seed();
        $this->assertDatabaseCount('actions', 1);
        $this->actionRegistry->update('api.v1.json_api.collect', $name = 'api.test');
        $this->assertDatabaseCount('actions', 1);

        $action = Action::query()
            ->where('name', 'api.test')
            ->first();

        $this->assertInstanceOf(ActionInterface::class, $action);

        $this->expectException(ValidationException::class);
        $this->actionRegistry->update('api.test', null, 'some method');

        $this->expectException(ModelNotFoundException::class);
        $this->actionRegistry->update('api.v1.json_api.collect');
    }

    public function testDestroy(): void
    {
        $this->seed();
        $this->assertDatabaseCount('actions', 1);
        $this->actionRegistry->destroy('api.v1.json_api.collect');
        $this->assertDatabaseCount('actions', 0);
    }
}
