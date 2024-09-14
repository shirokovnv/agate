<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\SchemaController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SchemaControllerTest extends TestCase
{
    protected string $endpoint = '/api/internal/v1/schema';

    public function testIntrospectActionSchema(): void
    {
        $response = $this->getJson($this->endpoint.'/actions');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json
            ->hasAll([
                '$schema',
                'type',
                'properties',
                'required',
                'additionalProperties',
            ])
            ->hasAll([
                'properties.pattern',
                'properties.method',
                'properties.name',
                'properties.priority',
                'properties.workflows',
            ])
        );
    }

    public function testIntrospectServiceSchema(): void
    {
        $response = $this->getJson($this->endpoint.'/services');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json
            ->hasAll([
                '$schema',
                'type',
                'properties',
                'required',
                'additionalProperties',
            ])
            ->hasAll([
                'properties.base_url',
                'properties.name',
            ])
        );
    }
}
