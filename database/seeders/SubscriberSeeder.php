<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    public function run(): void
    {
        $amount = 8;

        $this->command->info('Seeding ' . $amount . ' subscribers');

        Subscriber::factory()->count($amount)->create();
    }
}
