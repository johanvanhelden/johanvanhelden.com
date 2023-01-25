<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Tool> */
class ToolFactory extends Factory
{
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-3 months', '-2 hours');
        $updatedAt = $createdAt;

        if ($this->faker->boolean()) {
            $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
        }

        $image = basename(
            $this->faker->file(resource_path('img/tools'), config('filesystems.disks.tools.root'))
        );

        return [
            'name'       => ucfirst($this->faker->words(rand(1, 2), true)),
            'image'      => $image,
            'url'        => $this->faker->url,

            'publish_at' => $this->faker->optional(0.8)->dateTimeThisYear('now'),

            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    public function published(bool $value = true): static
    {
        return $this->state(function () use ($value) {
            if ($value) {
                $publishedAt = $this->faker->dateTimeThisYear('now');
            }

            return [
                'publish_at' => $publishedAt ?? null,
            ];
        });
    }
}
