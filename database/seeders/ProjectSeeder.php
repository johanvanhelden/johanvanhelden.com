<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding 6 projects');

        Project::factory()->count(3)->published()->create();
        Project::factory()->count(3)->published(false)->create();
    }
}
