<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'address' => $faker->address(),
    'bd' => $faker->date(),
    'about' => $faker->sentence(10, true),
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'skype' => substr($faker->e164PhoneNumber, 1, 11),
    'messanger' => null,
    'role' => $faker->numberBetween(0, 1),
    'city_id' => $faker->numberBetween(1, 1000),
    'average_rating' => $faker->numberBetween(1, 5),
    'avatar_link' => $faker->image(null, 120, 120, 'faces', true),
];
