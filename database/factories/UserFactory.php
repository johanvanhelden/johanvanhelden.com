<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 hours');
    $updatedAt = $createdAt;

    if ($faker->boolean()) {
        $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
    }

    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'password'          => Hash::make('password'),
        'remember_token'    => Str::random(10),
        'email_verified_at' => $faker->dateTimeThisYear,

        'created_at' => $createdAt,
        'updated_at' => $updatedAt,
    ];
});

foreach (array_keys(config('defaults.roles')) as $role) {
    $factory->afterCreatingState(User::class, $role, function (User $user) use ($role): void {
        $user->assignRole($role);
    });
}
