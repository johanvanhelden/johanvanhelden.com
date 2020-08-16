<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(Bootstrapper::class);

        $this->call(UserSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ToolSeeder::class);
        $this->call(SubscriberSeeder::class);
    }
}
