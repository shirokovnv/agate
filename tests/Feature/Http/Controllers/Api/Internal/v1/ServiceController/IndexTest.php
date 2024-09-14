<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ServiceController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends ServiceControllerTestCase
{
    public function testIndexSuccessfully(): void
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->each(fn (AssertableJson $json) => $json->hasAll(['name', 'base_url'])
        )
        );
    }
}
