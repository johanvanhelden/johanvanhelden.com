<?php

use Illuminate\Database\Seeder;

/**
 * Runs the bootstrappers.
 */
class Bootstrapper extends Seeder
{
    /**
     * Bootstrap the application.
     */
    public function run()
    {
        $this->command->info('Running the application bootstrapper');

        Artisan::call('bootstrap:application');

        $this->command->info('Finished application bootstrapping');
    }
}
