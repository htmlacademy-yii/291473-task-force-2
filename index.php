<?php

require_once 'task.php';

// Задаю моковые данные для задачи (id заказчика, id исполнителя, текущий статус);
$customer_id = 1;
$executor_id = 1;
$current_status = Task::STATUS_IN_PROGRESS;
$current_action = Task::ACTION_START;

// Создаю экземпляр класса Задачи;
$task = new Task($customer_id, $executor_id, $current_status);

$all_task_statuses = $task->get_statuses_map();
$all_task_actions = $task->get_actions_map();
$possible_status = $task->get_possible_status($current_action);
$possible_action = $task->get_possible_action();


print_r($all_task_statuses);
print('<br>');
print_r($all_task_actions);
print('<br>');
print($possible_status);
print('<br>');
print_r($possible_action);