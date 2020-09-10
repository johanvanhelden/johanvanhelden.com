<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class Bootstrapper extends Seeder
{
    public function run(): void
    {
        $this->command->info('Running the application bootstrapper');

        Artisan::call('bootstrap:application');

        $this->command->info('Finished application bootstrapping');
    }
}
