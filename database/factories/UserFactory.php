<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\User> */
class UserFactory extends Factory
{
    public function definition(): array
    {
        static $password;

        $createdAt = $this->faker->dateTimeBetween('-3 months', '-2 hours');
        $updatedAt = $createdAt;

        if ($this->faker->boolean()) {
            $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
        }

        return [
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->safeEmail,
            'password'          => $password ?: $password = Hash::make('password'),
            'remember_token'    => Str::random(10),
            'email_verified_at' => $this->faker->dateTimeThisYear,

            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
