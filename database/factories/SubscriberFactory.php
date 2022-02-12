<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\Subscriber> */
class SubscriberFactory extends Factory
{
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-3 months', '-2 hours');
        $updatedAt = $createdAt;

        if ($this->faker->boolean()) {
            $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
        }

        return [
            'uuid'   => Str::uuid()->toString(),
            'name'   => $this->faker->name,
            'email'  => $this->faker->unique()->safeEmail,
            'secret' => hash_hmac('sha256', Str::random(40), config('app.key')),

            'confirmed_at' => $this->faker->optional(0.8)->dateTimeThisYear('now'),

            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    public function confirmed(bool $value = true): static
    {
        return $this->state(function () use ($value) {
            if ($value) {
                $confirmedAt = $this->faker->dateTimeThisYear('now');
            }

            return [
                'confirmed_at' => $confirmedAt ?? null,
            ];
        });
    }
}
