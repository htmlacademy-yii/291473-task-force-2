CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    category VARCHAR(128) NOT NULL,
);

CREATE TABLE locations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(128) NOT NULL,
    coords VARCHAR(128) NOT NULL,
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    role INT UNSIGNED NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL,
    description VARCHAR(128) NOT NULL,
    name VARCHAR(128) NOT NULL,
    birthday INT UNSIGNED NOT NULL,
    location_id VARCHAR(128) NOT NULL,
    average_rating INT UNSIGNED NOT NULL,
    avatar_link VARCHAR(128) NOT NULL,
    phone VARCHAR(128) NOT NULL,
    skype VARCHAR(128) NOT NULL,
    messanger VARCHAR(128) NOT NULL,
    password CHAR(64) NOT NULL,
    FOREIGN KEY (user_location_id) REFERENCES locations(id),
    UNIQUE INDEX email(email)
);

CREATE TABLE users_specializations (
    user_id INT UNSIGNED NOT NULL,
    specialization_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (specialization_id) REFERENCES categories(id),
);


CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    status INT UNSIGNED NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    executor_id INT UNSIGNED NOT NULL,
    name VARCHAR(128) NOT NULL,
    description VARCHAR(128) NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    location_id INT UNSIGNED NOT NULL,
    location_coords INT UNSIGNED NOT NULL,
    price INT UNSIGNED NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deadline TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_link VARCHAR(128),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (location_coords) REFERENCES locations(location_coords),
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (executor_id) REFERENCES users(id),
);

CREATE TABLE reviews (
    user_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,
    rating INT UNSIGNED NOT NULL,
    review VARCHAR(128) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id),
);

CREATE TABLE responses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    comment VARCHAR(128) NOT NULL,
    price INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id),
);

-- CREATE TABLE users_tasks (
--     user_id INT UNSIGNED NOT NULL,
--     task_id INT UNSIGNED NOT NULL,
--     FOREIGN KEY (user_id) REFERENCES users(id),
--     FOREIGN KEY (task_id) REFERENCES tasks(id)
-- );
