<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->date(),
    'rate' => $faker->randomNumber(5, false),
    'description' => $faker->sentence(10, true),
    'customer_id' => $index + 1,
    'executor_id' => $faker->randomDigitNot($index + 1),
    'task_id' => $index + 1,
    'rating' => $faker->numberBetween(1, 8),
];
