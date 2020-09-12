<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /** @var string */
    protected $model = Project::class;

    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-3 months', '-2 hours');
        $updatedAt = $createdAt;

        if ($this->faker->boolean()) {
            $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
        }

        return [
            'name'    => ucfirst($this->faker->words(rand(1, 2), true)),
            'slug'    => $this->faker->slug(),
            'excerpt' => $this->faker->realText(100),
            'content' => $this->faker->realText(2000),
            'url'     => $this->faker->url,

            'publish_at' => $this->faker->optional(0.8)->dateTimeThisYear('now'),

            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    public function published(bool $value = true): Factory
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
