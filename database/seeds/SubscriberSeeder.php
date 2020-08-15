<?php

declare(strict_types=1);

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    public function run(): void
    {
        $amount = 8;
        $progressBar = $this->command->getOutput()->createProgressBar($amount);

        $this->command->info('Seeding ' . $amount . ' subscribers');

        factory(Subscriber::class, $amount)->create()->each(function () use ($progressBar): void {
            $progressBar->advance();
        });

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding subscribers');
    }
}
