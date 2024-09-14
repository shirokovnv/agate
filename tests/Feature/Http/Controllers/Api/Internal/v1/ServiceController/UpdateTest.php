<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ServiceController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class UpdateTest extends ServiceControllerTestCase
{
    public function testUpdateSuccessfully(): void
    {
        $schema = ['base_url' => 'https://google.com'];

        $response = $this->putJson($this->endpoint.'/'.$this->existingNameId, $schema);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->where('status', 'updated'));
    }

    public function testValidationErrors(): void
    {
        $schema = ['base_url' => 'some url'];
        $response = $this->putJson($this->endpoint.'/'.$this->existingNameId, $schema);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNotFoundError(): void
    {
        $response = $this->putJson($this->endpoint.'/'.$this->nonExistingNameId, []);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
