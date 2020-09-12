<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $amount = 8;
        $progressBar = $this->command->getOutput()->createProgressBar($amount);

        $this->command->info('Seeding ' . $amount . ' users');

        User::factory()->count($amount)->create()
            ->each(function ($user) use ($progressBar): void {
                $user->assignRole('user');

                $progressBar->advance();
            });

        $progressBar->finish();
    }
}
