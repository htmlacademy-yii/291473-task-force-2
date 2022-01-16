<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->date(),
    'category_id' => $faker->numberBetween(1, 8),
    'description' => $faker->sentence(10, true),
    'expire' => $faker->date(),
    'name' => $faker->jobTitle(),
    'address' => $faker->address(),
    'budget' => $faker->randomNumber(5, false),
    'latitude' => $faker->latitude($min = -90, $max = 90),
    'longitude' => $faker->longitude($min = -180, $max = 180),
    'status' => $faker->numberBetween(0, 1),
    'customer_id' => $index + 1,
    'executor_id' => $faker->randomDigitNot($index + 1),
    'city_id' => $faker->numberBetween(1, 1000),
    'file_link' => $faker->url(),
];
