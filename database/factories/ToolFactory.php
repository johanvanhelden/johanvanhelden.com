<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Tool;
use Faker\Generator as Faker;

$factory->define(Tool::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 hours');
    $updatedAt = $createdAt;

    if ($faker->boolean()) {
        $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
    }

    $image = basename(
        $faker->file(resource_path('img/tools'), config('filesystems.disks.tools.root'))
    );

    return [
        'name'  => ucfirst($faker->words(rand(1, 2), true)),
        'image' => $image,
        'url'   => $faker->url,

        'publish_at' => $faker->optional(0.8)->dateTimeThisYear('now'),

        'created_at' => $createdAt,
        'updated_at' => $updatedAt,
    ];
});

$factory->state(Tool::class, 'published', function (Faker $faker) {
    return [
        'publish_at' => $faker->dateTimeThisYear('now'),
    ];
});

$factory->state(Tool::class, 'unpublished', function () {
    return [
        'publish_at' => null,
    ];
});
