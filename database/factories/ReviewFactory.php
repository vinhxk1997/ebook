<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Review::class, function (Faker $faker) {
    $name = $faker->text(30);

    return [
        'title' => $name,
        'slug' => str_slug($name),
        'content' => $faker->paragraph,
    ];
});
