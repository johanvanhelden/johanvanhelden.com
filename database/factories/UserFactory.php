<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /** @var string */
    protected $model = User::class;

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
