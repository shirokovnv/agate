<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ServiceController;

use Symfony\Component\HttpFoundation\Response;

class StoreTest extends ServiceControllerTestCase
{
    public function testStoreSuccessfully(): void
    {
        $schemas = $this->validSchemaGenerator();

        foreach ($schemas as $schema) {
            $response = $this->postJson($this->endpoint, $schema);
            $response->assertStatus(Response::HTTP_OK);
        }
    }

    public function testValidationErrors(): void
    {
        $schemas = $this->invalidSchemaGenerator();

        foreach ($schemas as $schema) {
            $response = $this->postJson($this->endpoint, $schema);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function validSchemaGenerator(): \Generator
    {
        yield ['name' => 'test1', 'base_url' => 'http://url1'];
        yield ['name' => 'test2', 'base_url' => 'http://url2'];
    }

    private function invalidSchemaGenerator(): \Generator
    {
        yield [];
        yield ['base_url' => 'some url'];
    }
}
