<?php

use Illuminate\Database\Seeder;

/**
 * Seeds the database.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(Bootstrapper::class);

        $this->call(UserSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ToolSeeder::class);
        $this->call(SubscriberSeeder::class);
    }
}
