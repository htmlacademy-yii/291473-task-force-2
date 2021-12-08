<?php

use TaskForce\tasks\Task;
use TaskForce\utils\CsvToSqlConverter;
use TaskForce\exceptions\StatusException;
use TaskForce\utils\CheckDirectory;

require_once 'vendor/autoload.php';

// Моковые данные;
$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$current_status = Task::STATUS_NEW;
$current_action = Task::ACTION_START;

// Конвертация и загрузка csv-файлов в sql;

// Список директорий для csv и sql-файлов;
$csv_directory = 'data/';
$sql_directory = 'sql/';

// Список csv-файлов;
$csv_files = new checkDirectory($csv_directory);
$csv_files_list = $csv_files->get_csv_files();
// print_r($csv_files_list);

$csv_to_sql_converter = new CsvToSqlConverter($sql_directory);

// $csv_to_sql_converter->convert_csv_file($csv_files_list[0]); // Проверяю работу на одном файле csv;

foreach ($csv_files_list as $csv_file) {
    // print($csv_file . '<br>');
    $csv_to_sql_converter->convert_csv_file($csv_file);
}

// $csv_file = new CsvToSqlConverter($directory);
// $sql_file = $csv_file->convert_csv_file('data/cities.csv');

// Получаю список csv-файлов в заданной директории;
// $csv_files = new CheckDirectory($csv_directory);
// $csv_files_list = $csv_files->get_csv_files();


// Закомментировал варианты статусов и активность для тестирования исключений;
// $current_status = Task::STATUS_ERROR;
// $current_status = Task::STATUS_FAILED;
// $current_action = Task::ACTION_ERROR;

try {
    $task = new Task($customer_id, $executor_id, $user_id, $current_status);
    $all_task_statuses = $task->get_statuses_map(); // Карта статусов;
    $all_task_actions = $task->get_actions_map(); // Карта действий;
    $possible_action = $task->get_user_actions($current_status); // Возможные действия;
    $next_status = $task->get_next_status($current_action); // Следующий статус;
} catch (StatusException $error) {
    print('Выброшено исключение: ' . $error->getMessage() . '<br>');
}

// Закомментировал тесты из прошлого задания;

// $next_status = $task->get_next_status($current_action);

// print_r($task->get_user_actions($current_status));

// // Вывожу результаты;
// print('Все возможные статусы:' . '<br>');
// print_r($all_task_statuses);

// print('<br>' . 'Все возможные действия:' . '<br>');
// print_r($all_task_actions);

// print('<br>' . 'Следующий статус:' . '<br>');
// print($next_status);

// // Вывожу следующее действие, в зависимости от статус задачи и типа пользователя;
// print('<br>' . 'STATUS_NEW, CUTOMER' . '<br>');
// $possible_action = $task->get_user_actions($current_status);
// print_r($task->get_user_actions($current_status));

// print('<br>' . 'STATUS_NEW, EXECUTOR' . '<br>');
// $user_id = 2;
// $current_status = Task::STATUS_NEW;
// $task = new Task($customer_id, $executor_id, $user_id, $current_status);
// print_r($task->get_user_actions($current_status));

// print('<br>' . 'STATUS_IN_PROGRESS, CUTOMER' . '<br>');
// $user_id = 1;
// $current_status = Task::STATUS_IN_PROGRESS;
// $task = new Task($customer_id, $executor_id, $user_id, $current_status);
// print_r($task->get_user_actions($current_status));

// print('<br>' . 'STATUS_IN_PROGRESS, EXECUTOR' . '<br>');
// $user_id = 2;
// $current_status = Task::STATUS_IN_PROGRESS;
// $task = new Task($customer_id, $executor_id, $user_id, $current_status);
// print_r($task->get_user_actions($current_status));

// print('<br>' . 'STATUS_IN_PROGRESS, NOT CUSTOMER OR EXECUTOR' . '<br>'); // NULL
// $user_id = 3;
// $current_status = Task::STATUS_IN_PROGRESS;
// $task = new Task($customer_id, $executor_id, $user_id, $current_status);
// print_r($task->get_user_actions($current_status));
