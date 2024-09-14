<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ActionController;

use Symfony\Component\HttpFoundation\Response;

class StoreTest extends ActionControllerTestCase
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
        yield [
            'name' => 'api.test',
            'method' => 'GET',
            'priority' => 1,
            'pattern' => '/test/{ID}',
            'workflows' => [
                [
                    'type' => 'parallel',
                    'steps' => [
                        [
                            'method' => 'GET',
                            'service' => 'json-api',
                            'path' => 'posts/{ID}',
                            'out_key' => 'posts',
                        ],
                    ],
                ],
                [
                    'type' => 'sequential',
                    'steps' => [
                        [
                            'method' => 'GET',
                            'service' => 'json-api',
                            'path' => 'todos/{ID}',
                            'out_key' => 'todos',
                        ],
                    ],
                ],
            ],
        ];
    }

    private function invalidSchemaGenerator(): \Generator
    {
        yield [];
        yield ['method' => 'some method'];
        yield ['method' => 'get', 'name' => 'some name', 'priority' => 'p'];
        yield ['method' => 'post', 'name' => 'test', 'priority' => 1, 'workflows' => [
            [
                'type' => 'some workflow type',
                'steps' => [],
            ],
        ]];
    }
}
