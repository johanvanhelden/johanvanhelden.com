<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Bootstraps the application.
 */
class BootstrapApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bootstrap:application';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bootstraps the application.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Bootstrapping application...');

        $this->call('bootstrap:permissions');
        $this->call('bootstrap:users');

        $this->info('Bootstrapping done');
    }
}
