<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ActionController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class ShowTest extends ActionControllerTestCase
{
    public function testShowSuccessfully(): void
    {
        $response = $this->getJson($this->endpoint.'/'.$this->existingNameId);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['name', 'method', 'pattern', 'priority', 'workflows'])
        );
    }

    public function testNotFoundError(): void
    {
        $response = $this->getJson($this->endpoint.'/'.$this->nonExistingNameId);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
