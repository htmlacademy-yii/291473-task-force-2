<?php
require_once 'task.php';

// Задаю моковые данные для задачи (id заказчика, id исполнителя, текущий статус);
$customer_id = 1;
$executor_id = 1;
$current_status = Task::STATUS_IN_PROGRESS;
$current_action = Task::ACTION_START;

// Создаю экземпляр класса Задачи;
$task = new Task($customer_id, $executor_id, $current_status);

// Проверяю работу методов;
$all_task_statuses = $task->get_statuses_map();
$all_task_actions = $task->get_actions_map();

$next_status = $task->get_next_status($current_action);
$possible_action = $task->get_possible_actions();

// Вывожу результаты;
print('Все возможные статусы:' . '<br>');
print_r($all_task_statuses);

print('<br>' . 'Все возможные действия:' . '<br>');
print_r($all_task_actions);

print('<br>' . 'Текущий статус:' . '<br>');
print($next_status);

print('<br>' . 'Текущие возможные действия' . '<br>');
print_r($possible_action);

// Тестирую класс. В php.ini установил zend.assertions = 1;
print('<br>' . 'Тестирование класса. Если все верно, ниже не должно быть ошибок:' . '<br>');
assert($task->get_next_status('canceled') == Task::STATUS_CANCELED, 'cancel action');

// print('<br>');
// print('<br>');
// print_r($task->get_possible_actions());
// print('<br>');
// print_r([Task::ACTION_FINISHED, Task::ACTION_REFUSED]);
// // В php.ini установил zend.assertions = 1

// assert($task->get_possible_actions() == [Task::ACTION_FINISHED, Task::ACTION_REFUSED], 'cancel action');
// // assert($task->get_possible_status('canceled') == Task::STATUS_CANCELED, 'cancel action');
