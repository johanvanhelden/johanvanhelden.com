<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Subscriber;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Subscriber::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 hours');
    $updatedAt = $createdAt;

    if ($faker->boolean()) {
        $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
    }

    return [
        'uuid'   => Str::uuid()->toString(),
        'name'   => $faker->name,
        'email'  => $faker->unique()->safeEmail,
        'secret' => hash_hmac('sha256', Str::random(40), config('app.key')),

        'confirmed_at' => $faker->optional(0.8)->dateTimeThisYear('now'),

        'created_at' => $createdAt,
        'updated_at' => $updatedAt,
    ];
});

$factory->state(Subscriber::class, 'confirmed', function (Faker $faker) {
    return [
        'confirmed_at' => $faker->dateTimeThisYear('now'),
    ];
});

$factory->state(Subscriber::class, 'unconfirmed', function () {
    return [
        'confirmed_at' => null,
    ];
});
