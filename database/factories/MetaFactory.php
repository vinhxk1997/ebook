<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Meta::class, function (Faker $faker) {
    $name = $faker->text(15);

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'type' => 'category',
    ];
});
