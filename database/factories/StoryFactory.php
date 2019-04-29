<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Story::class, function (Faker $faker) {
    $name = $faker->text(30);

    return [
        'title' => $name,
        'slug' => str_slug($name),
        'summary' => $faker->paragraph(5),
        'is_recommended' => rand(0, 1),
        'status' => rand(0, 1)
    ];
});

$factory->afterCreating(App\Models\Story::class, function ($story, $faker) {
    factory(App\Models\Chapter::class, rand(5, 20))->create([
        'story_id' => $story->id
    ]);
    $user = App\Models\User::inRandomOrder()
        ->first();
    $story->reviews()->saveMany(factory(App\Models\Review::class, rand(1, 3))->make(['user_id' => $user->id]));
});
