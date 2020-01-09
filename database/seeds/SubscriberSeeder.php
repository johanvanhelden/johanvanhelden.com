<?php

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

/**
 * Generate subscribers.
 */
class SubscriberSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $amount = 8;
        $progressBar = $this->command->getOutput()->createProgressBar($amount);

        $this->command->info('Seeding ' . $amount . ' subscribers');

        factory(Subscriber::class, $amount)->create()->each(function () use ($progressBar) {
            $progressBar->advance();
        });

        $progressBar->finish();

        $this->command->info('');
        $this->command->info('Finished seeding subscribers');
    }
}
