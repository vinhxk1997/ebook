<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Chapter::class, function (Faker $faker) {
    $name = $faker->text(30);

    return [
        'title' => $name,
        'slug' => str_slug($name),
        'content' => $faker->paragraph(20, true),
        'status' => rand(0, 1)
    ];
});
