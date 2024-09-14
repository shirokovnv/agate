<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Action::factory()->withJsonApiWorkflow()->create();
        Service::factory()->create(['name' => 'json-api', 'base_url' => 'https://jsonplaceholder.typicode.com/']);
    }
}
