<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->date(),
    'rate' => $faker->randomNumber(5, false),
    'description' => $faker->sentence(10, true),
    'executor_id' => $faker->randomDigitNot($index + 1),
    'task_id' => $index + 1,
];
