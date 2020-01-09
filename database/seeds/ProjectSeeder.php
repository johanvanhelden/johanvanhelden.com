<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Generate projects.
 */
class ProjectSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $progressBar = $this->command->getOutput()->createProgressBar(6);

        $this->command->info('Seeding 6 projects');

        factory(Project::class, 3)
            ->state('published')
            ->create()
            ->each(function () use ($progressBar) {
                $progressBar->advance();
            });

        factory(Project::class, 3)
            ->state('unpublished')
            ->create()
            ->each(function () use ($progressBar) {
                $progressBar->advance();
            });

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding projects');
    }
}
