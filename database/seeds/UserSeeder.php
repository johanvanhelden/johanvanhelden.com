<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Generate users.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $amount = 8;
        $progressBar = $this->command->getOutput()->createProgressBar($amount);

        $this->command->info('Seeding ' . $amount . ' users');

        factory(User::class, $amount)->create()->each(function ($user) use ($progressBar) {
            $user->assignRole('user');

            $progressBar->advance();
        });

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding users');
    }
}
