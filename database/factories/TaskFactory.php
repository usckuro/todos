<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(80),
        'description' => $faker->text(rand(20,200)),
        'status' => $faker->randomElement(['pending', 'complete'])
    ];
});
