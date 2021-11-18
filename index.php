<?php

use TaskForce\tasks\Task;

require_once 'vendor/autoload.php';

// Моковые данные;
$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$current_status = Task::STATUS_NEW;
$current_action = Task::ACTION_START;

// Экземпляр класса Задачи;
$task = new Task($customer_id, $executor_id, $user_id, $current_status);

// Проверяю работу методов;
$all_task_statuses = $task->get_statuses_map();
$all_task_actions = $task->get_actions_map();
$next_status = $task->get_next_status($current_action);

// Вывожу результаты;
print('Все возможные статусы:' . '<br>');
print_r($all_task_statuses);

print('<br>' . 'Все возможные действия:' . '<br>');
print_r($all_task_actions);

print('<br>' . 'Следующий статус:' . '<br>');
print($next_status);

// Вывожу следующее действие, в зависимости от статус задачи и типа пользователя;
print('<br>' . 'STATUS_NEW, CUTOMER' . '<br>');
$possible_action = $task->get_user_actions($current_status);
print_r($task->get_user_actions($current_status));

print('<br>' . 'STATUS_NEW, EXECUTOR' . '<br>');
$user_id = 2;
$current_status = Task::STATUS_NEW;
$task = new Task($customer_id, $executor_id, $user_id, $current_status);
print_r($task->get_user_actions($current_status));

print('<br>' . 'STATUS_IN_PROGRESS, CUTOMER' . '<br>');
$user_id = 1;
$current_status = Task::STATUS_IN_PROGRESS;
$task = new Task($customer_id, $executor_id, $user_id, $current_status);
print_r($task->get_user_actions($current_status));

print('<br>' . 'STATUS_IN_PROGRESS, EXECUTOR' . '<br>');
$user_id = 2;
$current_status = Task::STATUS_IN_PROGRESS;
$task = new Task($customer_id, $executor_id, $user_id, $current_status);
print_r($task->get_user_actions($current_status));

print('<br>' . 'STATUS_IN_PROGRESS, NOT CUSTOMER OR EXECUTOR' . '<br>'); // NULL
$user_id = 3;
$current_status = Task::STATUS_IN_PROGRESS;
$task = new Task($customer_id, $executor_id, $user_id, $current_status);
print_r($task->get_user_actions($current_status));
