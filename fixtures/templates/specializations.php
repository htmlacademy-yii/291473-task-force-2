<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'user_id' => $index + 1,
    'specialization_id' => $faker->numberBetween(1, 20),
];
