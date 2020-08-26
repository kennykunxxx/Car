<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'make' => $faker->company,
        'model' => $faker->name,
        'registration' => $faker->name,
        'color' => $faker->colorName,

    ];
});
