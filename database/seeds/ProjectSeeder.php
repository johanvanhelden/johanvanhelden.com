<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $progressBar = $this->command->getOutput()->createProgressBar(6);

        $this->command->info('Seeding 6 projects');

        factory(Project::class, 3)
            ->state('published')
            ->create()
            ->each(function () use ($progressBar): void {
                $progressBar->advance();
            });

        factory(Project::class, 3)
            ->state('unpublished')
            ->create()
            ->each(function () use ($progressBar): void {
                $progressBar->advance();
            });

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding projects');
    }
}
