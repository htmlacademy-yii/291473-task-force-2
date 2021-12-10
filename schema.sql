CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(128) NOT NULL,
    icon VARCHAR(128) NOT NULL
);

CREATE TABLE cities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    city VARCHAR(128) NOT NULL,
    lat VARCHAR(128) NOT NULL,
    long VARCHAR(128) NOT NULL
);

CREATE TABLE profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    address VARCHAR(128) NOT NULL,
    bd INT UNSIGNED NOT NULL,
    about VARCHAR(128) NOT NULL,
    phone VARCHAR(128) NOT NULL,
    skype VARCHAR(128) NOT NULL,
    role INT UNSIGNED NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL,
    name VARCHAR(128) NOT NULL,
    city_id INT UNSIGNED NOT NULL,
    average_rating INT UNSIGNED NOT NULL,
    avatar_link VARCHAR(128) NOT NULL,
    messanger VARCHAR(128) NOT NULL,
    password CHAR(64) NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id),
    UNIQUE INDEX email(email)
);

CREATE TABLE users_specializations (
    user_id INT UNSIGNED NOT NULL,
    specialization_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES profiles(id),
    FOREIGN KEY (specialization_id) REFERENCES categories(id)
);


CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    status INT UNSIGNED NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    executor_id INT UNSIGNED NOT NULL,
    name VARCHAR(128) NOT NULL,
    description VARCHAR(128) NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    city_id INT UNSIGNED NOT NULL,
    price INT UNSIGNED NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deadline TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_link VARCHAR(128),
    FOREIGN KEY (customer_id) REFERENCES profiles(id),
    FOREIGN KEY (executor_id) REFERENCES profiles(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (city_id) REFERENCES cities(id)
);

CREATE TABLE opinions (
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rate INT UNSIGNED NOT NULL,
    description VARCHAR(128) NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    executor_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES profiles(id),
    FOREIGN KEY (executor_id) REFERENCES profiles(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE responses (
    executor_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    comment VARCHAR(128) NOT NULL,
    price INT UNSIGNED NOT NULL,
    FOREIGN KEY (executor_id) REFERENCES profiles(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);