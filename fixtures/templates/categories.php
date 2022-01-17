<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'name' => $faker->word(),
    'icon' => $faker->image(null, 640, 480, 'pictures', true),
];
