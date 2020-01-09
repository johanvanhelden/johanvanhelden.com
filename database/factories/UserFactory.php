<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(User::class, function (Generator $faker) {
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
    $factory->afterCreatingState(User::class, $role, function ($user) use ($role) {
        $user->assignRole($role);
    });
}
