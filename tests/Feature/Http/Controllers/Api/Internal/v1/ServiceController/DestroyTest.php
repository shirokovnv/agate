<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\v1\ServiceController;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class DestroyTest extends ServiceControllerTestCase
{
    public function testDestroySuccessfully(): void
    {
        $response = $this->deleteJson($this->endpoint.'/'.$this->existingNameId);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->where('status', 'deleted'));
    }

    public function testNotFoundError(): void
    {
        $response = $this->deleteJson($this->endpoint.'/'.$this->nonExistingNameId);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
