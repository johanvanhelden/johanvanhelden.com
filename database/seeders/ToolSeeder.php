<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    public function run(): void
    {
        $tools = [
            'ubuntu'    => 'Ubuntu',
            'github'    => 'GitHub',
            'vscode'    => 'VS Code',
            'docker'    => 'Docker',
            'laravel'   => 'Laravel',
            'vuejs'     => 'Vue.js',
            'gitkraken' => 'GitKraken',
            'gimp'      => 'Gimp',
        ];

        $this->command->info('Seeding ' . count($tools) . ' tools');

        foreach ($tools as $name) {
            Tool::factory()->create(['name' => $name]);
        }
    }
}
