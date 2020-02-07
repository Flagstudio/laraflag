<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Settings::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'slug' => $faker->unique()->word,
        'fields' => [],
    ];
});
