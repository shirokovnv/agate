<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
final class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function withJsonApiWorkflow(): Factory
    {
        return $this->state(function (array $attributes) {
            $steps = [
                [
                    'method' => 'GET',
                    'service' => 'json-api',
                    'path' => 'posts/{ID}',
                    'out_key' => 'posts',
                ],
                [
                    'method' => 'GET',
                    'service' => 'json-api',
                    'path' => 'todos/{ID}',
                    'out_key' => 'todos',
                ],
                [
                    'method' => 'GET',
                    'service' => 'json-api',
                    'path' => 'users/$req.data.id',
                    'out_key' => 'users',
                ],
                [
                    'method' => 'GET',
                    'service' => 'json-api',
                    'path' => 'albums/5?client_id=$req.data.id',
                    'out_key' => 'albums',
                ],
            ];

            return [
                'name' => 'api.v1.json_api.collect',
                'method' => 'GET',
                'pattern' => '/collect/{ID}',
                'priority' => 1,
                'workflows' => [
                    [
                        'type' => 'parallel',
                        'steps' => $steps,
                    ],
                ],
            ];
        });
    }
}
