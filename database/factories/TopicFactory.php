<?php

use Faker\Generator as Faker;

$factory->define(App\Topic::class, function (Faker $faker) {
    $title = $faker->unique()->text;
    return [
        'title' => $title,
        'slug' => str_slug($title, '-')
    ];
});
