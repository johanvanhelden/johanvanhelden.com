<?php

use App\Models\Tool;
use Illuminate\Database\Seeder;

/**
 * Generate tools.
 */
class ToolSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $tools = [
            'ubuntu'    => 'Ubuntu',
            'github'    => 'GitHub',
            'vscode'    => 'VS Code',
            'docker'    => 'Docker',
            'laravel'   => 'Laravel',
            'vuejs'     => 'Vue.js',
            'gitkraken' => 'GitKraken',
            'gimp'      => 'Gimp',
        ];

        $progressBar = $this->command->getOutput()->createProgressBar(count($tools));

        $this->command->info('Seeding ' . count($tools) . ' tools');

        foreach ($tools as $name) {
            factory(Tool::class)
                ->create(['name' => $name])
                ->each(function () use ($progressBar) {
                    $progressBar->advance();
                });
        }

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding tools');
    }
}
