CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE specializations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    specialization VARCHAR(128) NOT NULL,
);

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    category VARCHAR(128) NOT NULL,
);

CREATE TABLE reviews (
    user_id INT UNSIGNED NOT NULL,
    user_rating INT UNSIGNED NOT NULL,
    user_review VARCHAR(128) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
);

CREATE TABLE locations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    location_name VARCHAR(128) NOT NULL,
    location_coords VARCHAR(128) NOT NULL,
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL,
    user_name VARCHAR(128) NOT NULL,
    age INT UNSIGNED NOT NULL,
    user_location VARCHAR(128) NOT NULL,
    user_average_rating INT UNSIGNED NOT NULL,
    user_specializations_id INT UNSIGNED NOT NULL,
    password CHAR(64) NOT NULL,
    FOREIGN KEY (user_specializations_id) REFERENCES specializations(id),
    UNIQUE INDEX email(email)
);

CREATE TABLE responses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    response_user_id INT UNSIGNED NOT NULL,
    response_task_id INT UNSIGNED NOT NULL,
    response_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    comment VARCHAR(128) NOT NULL,
    response_price INT UNSIGNED NOT NULL,
    FOREIGN KEY (response_user_id) REFERENCES users(id),
    FOREIGN KEY (response_task_id) REFERENCES tasks(id),
);

CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    task_name VARCHAR(128) NOT NULL,
    task_description VARCHAR(128) NOT NULL,
    task_category_id INT UNSIGNED NOT NULL,
    task_location_id INT UNSIGNED NOT NULL,
    task_location_coords INT UNSIGNED NOT NULL,
    task_price INT UNSIGNED NOT NULL,
    task_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deadline TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    task_file VARCHAR(128),
    FOREIGN KEY (task_category_id) REFERENCES categories(id),
    FOREIGN KEY (task_location_id) REFERENCES locations(id),
    FOREIGN KEY (task_location_coords) REFERENCES locations(location_coords),
);

CREATE TABLE users_tasks (
    user_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);