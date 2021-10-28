<?php

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAILED = 'failed';
    const STATUS_FINISHED = 'finished';

    const ACTION_START = 'start';
    const ACTION_REFUSED = 'refused';
    const ACTION_CANCELED = 'canceled';
    const ACTION_FINISHED = 'finished';

    public $customer_id;
    public $executor_id;
    private $current_status;

    // Конструктор класса (получаем в нем ID исполнителя и ID заказчика);
    public function __construct($customer_id, $executor_id, $current_status)
    {
        this->customer_id = $customer_id;
        this->executor_id = $executor_id;
        this->current_status = $current_status;
    }

    // Метод для получения Карты статусов;
    public function get_statuses_map()
    {
        return [
            self::STATUS_NEW => 'Новое', // Задание опубликовано, исполнитель ещё не найден;
            self::STATUS_CANCELED => 'Отменено', // Заказчик отменил задание;
            self::STATUS_IN_PROGRESS => 'В работе', // Заказчик выбрал исполнителя для задания;
            self::STATUS_FINISHED => 'Выполнено', // Заказчик отметил задание как выполненное;
            self::STATUS_FAILED => 'Провалено', // Исполнитель отказался от выполнения задания;
        ];
    }

    // Метод для получения карты действий;
    public function get_actions_map()
    {
        return [
            self::ACTION_FINISHED => 'Завершение задания';
            self::ACTION_REFUSED => 'Отказ от задания';
            self::ACTION_CANCELED => 'Отмена задания';
            self::ACTION_START => 'Старт задания';
        ];
    }

    // Отлавливаю статусы и действия в зависимости друг от друга;
    public function get_possible_status()
    {

    }

    public function get_possible_action()
    {
        
    }
}
