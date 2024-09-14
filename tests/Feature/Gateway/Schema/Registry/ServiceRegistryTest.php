<?php

declare(strict_types=1);

namespace Tests\Feature\Gateway\Schema\Registry;

use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Gateway\Contracts\Schema\ServiceInterface;
use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ServiceRegistryTest extends TestCase
{
    use RefreshDatabase;

    protected ServiceRegistryInterface $serviceRegistry;

    protected function setUp(): void
    {
        parent::setUp();
        Service::query()->truncate();
        $this->serviceRegistry = $this->app->make(ServiceRegistryInterface::class);
    }

    protected function tearDown(): void
    {
        unset($this->serviceRegistry);
        parent::tearDown();
    }

    public function testGet(): void
    {
        $services = $this->serviceRegistry->get();
        $this->assertDatabaseCount('services', 0);
        $this->assertCount(0, $services);

        $this->seed();
        $services = $this->serviceRegistry->get();
        $this->assertDatabaseCount('services', 1);
        $this->assertCount(1, $services);
        foreach ($services as $service) {
            $this->assertInstanceOf(ServiceInterface::class, $service);
        }
    }

    public function testStore(): void
    {
        $this->assertDatabaseCount('services', 0);

        $this->serviceRegistry->store(
            'api-test',
            'https://example.com'
        );

        $this->assertDatabaseCount('services', 1);

        $service = Service::query()
            ->where('name', 'api-test')
            ->first();

        $this->assertInstanceOf(ServiceInterface::class, $service);
    }

    public function testFindByName(): void
    {
        $this->seed();
        $service = $this->serviceRegistry->findByName('json-api');
        $this->assertInstanceOf(ServiceInterface::class, $service);

        $this->expectException(ModelNotFoundException::class);
        $this->serviceRegistry->findByName('test-api');
    }

    public function testUpdate(): void
    {
        $this->seed();
        $this->assertDatabaseCount('services', 1);
        $this->serviceRegistry->update('json-api', 'json.api');
        $this->assertDatabaseCount('services', 1);

        $service = Service::query()
            ->where('name', 'json.api')
            ->first();

        $this->assertInstanceOf(ServiceInterface::class, $service);

        $this->expectException(ValidationException::class);
        $this->serviceRegistry->update('json.api', null, 'some url');

        $this->expectException(ModelNotFoundException::class);
        $this->serviceRegistry->update('test.api', 'new.api', 'new.url');
    }

    public function testDestroy(): void
    {
        $this->seed();
        $this->assertDatabaseCount('services', 1);
        $this->serviceRegistry->destroy('json-api');
        $this->assertDatabaseCount('services', 0);
    }
}
