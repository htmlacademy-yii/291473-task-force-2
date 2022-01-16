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
    'city_id' => $faker->numberBetween(1, 1000),
    'budget' => $faker->randomNumber(5, false),
    'status' => $faker->sentence(2, true),
    'customer_id' => $index + 1,
    'executor_id' => $faker->randomDigitNot($index + 1),
];
