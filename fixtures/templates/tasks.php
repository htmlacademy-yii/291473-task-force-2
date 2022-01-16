<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [


    // id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
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

    // file_link VARCHAR(128),
    // FOREIGN KEY (customer_id) REFERENCES users(id),
    // FOREIGN KEY (executor_id) REFERENCES users(id),
    // FOREIGN KEY (category_id) REFERENCES categories(id),
    // FOREIGN KEY (city_id) REFERENCES cities(id)
];
