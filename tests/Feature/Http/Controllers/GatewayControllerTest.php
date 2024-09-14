<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GatewayControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        Http::preventStrayRequests();
    }

    public function testRouteMatchedSuccessfully(): void
    {
        Http::fake([
            'https://jsonplaceholder.typicode.com/*' => Http::sequence()
                ->push([
                    'id' => 1,
                    'title' => 'Some post',
                ])
                ->push([
                    'id' => 1,
                    'title' => 'Some todo',
                ])
                ->push([
                    'id' => 1,
                    'name' => 'Some user',
                ])
                ->push([
                    'id' => 1,
                    'title' => 'Some album',
                ]),
        ]);

        $response = $this->getJson('/collect/1');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['posts', 'todos', 'users', 'albums'])
            ->where('posts.title', 'Some post')
            ->where('todos.title', 'Some todo')
            ->where('users.name', 'Some user')
            ->where('albums.title', 'Some album')
        );

        Http::assertSentCount(4);
    }

    public function testRouteDoesNotMatch(): void
    {
        $response = $this->getJson('/some_url');
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        Http::assertNothingSent();
    }

    public function testSecureHeadersWhenSendingRequests(): void
    {
        Http::fake([
            'https://jsonplaceholder.typicode.com/*' => Http::response([
                'id' => 1,
                'body' => 'Some body',
            ]),
        ]);

        Config::set('gateway.options.allowed_headers', ['Accept', 'Content-Type', 'granted-header']);

        $response = $this->getJson('/collect/1', ['granted-header' => 'grant', 'denied-header' => 'deny']);
        $response->assertStatus(Response::HTTP_OK);

        Http::assertSent(function (Request $request) {
            return
                $request->hasHeader('Host', 'jsonplaceholder.typicode.com') &&
                $request->hasHeader('granted-header', 'grant') &&
                ! $request->hasHeader('denied-header');
        });
    }

    public function testSentRequestHasUuidHeader(): void
    {
        Http::fake([
            'https://jsonplaceholder.typicode.com/*' => Http::response([
                'id' => 1,
                'body' => 'Some body',
            ]),
        ]);

        $response = $this->getJson('/collect/1');
        $response->assertStatus(Response::HTTP_OK);

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('x-request-uuid');
        });
    }
}
