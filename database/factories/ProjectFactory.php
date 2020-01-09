<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Project;
use Faker\Generator;

$factory->define(Project::class, function (Generator $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 hours');
    $updatedAt = $createdAt;

    if ($faker->boolean()) {
        $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
    }

    return [
        'name'    => ucfirst($faker->words(rand(1, 2), true)),
        'slug'    => $faker->slug(),
        'excerpt' => $faker->realText(100),
        'content' => $faker->realText(2000),
        'url'     => $faker->url,

        'publish_at' => $faker->optional(0.8)->dateTimeThisYear('now'),

        'created_at' => $createdAt,
        'updated_at' => $updatedAt,
    ];
});

$factory->state(Project::class, 'published', function (Generator $faker) {
    return [
        'publish_at' => $faker->dateTimeThisYear('now'),
    ];
});

$factory->state(Project::class, 'unpublished', function (Generator $faker) {
    return [
        'publish_at' => $faker->optional()->dateTimeBetween('+1 day', '+1 year'),
    ];
});
