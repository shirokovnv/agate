<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ActionController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends ActionControllerTestCase
{
    public function testIndexSuccessfully(): void
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->each(fn (AssertableJson $json) => $json->hasAll(['name', 'method', 'pattern', 'priority', 'workflows'])
        )
        );
    }
}
