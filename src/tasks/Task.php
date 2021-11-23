<?php

namespace TaskForce\tasks;

use TaskForce\exceptions\StatusException as StatusException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAILED = 'failed';
    const STATUS_FINISHED = 'finished';

    const STATUS_ERROR = 'Тестовый статус'; // Тестовый статус, для имитации ошибки - В конструкторе класса Task задан неверный статус;

    const ACTION_RESPOND = 'respond';
    const ACTION_START = 'start';
    const ACTION_REFUSED = 'refused';
    const ACTION_CANCELED = 'canceled';
    const ACTION_FINISHED = 'finished';

    public const ROLE_CUSTOMER = 'ЗАКАЗЧИК';
    public const ROLE_EXECUTOR = 'ИСПОЛНИТЕЛЬ';

    // public $customer_id;
    // public $executor_id;
    // private $current_status;

    // public $status = [
    //     'new' => 'Новое',
    //     'in_progress' => 'В работе',
    //     'canceled' => 'Отменено',
    //     'finished' => 'Выполнено',
    //     'failed' => 'Провалено'
    // ];

    public function __construct($customer_id, $executor_id, $user_id, $current_status)
    {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->user_id = $user_id;

        if (!isset($this->get_statuses_map()[$current_status])) {
            throw new  StatusException('В конструкторе класса Task задан неверный статус');
        }

        $this->current_status = $current_status;
    }

    // Карта статусов;
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

    //  Статус, после выполнения указанного действия;
    public function get_next_status($action)
    {
        switch ($action) {
            case self::ACTION_START:
                return self::STATUS_IN_PROGRESS;
            case self::ACTION_REFUSED:
                return self::STATUS_FAILED;
            case self::ACTION_CANCELED:
                return self::STATUS_CANCELED;
            case self::ACTION_FINISHED:
                return self::STATUS_FINISHED;
            default:
                return null;
        }
    }

    // Карта действий;
    public function get_actions_map()
    {
        return [
            self::ACTION_RESPOND => 'Добавление отклика',
            self::ACTION_START => 'Старт задания',
            self::ACTION_REFUSED => 'Отказ от задания',
            self::ACTION_CANCELED => 'Отмена задания',
            self::ACTION_FINISHED => 'Завершение задания',
        ];
    }

    // Список следующих действий, в зависимости от статуса задачи и роли пользователя;
    public $next_action = [
        self::STATUS_NEW => [
            self::ROLE_CUSTOMER => CancelAction::class,
            self::ROLE_EXECUTOR => RespondAction::class,
        ],
        self::STATUS_IN_PROGRESS => [
            self::ROLE_CUSTOMER => FinishAction::class,
            self::ROLE_EXECUTOR => RefuseAction::class,
        ]
    ];

    // Определяю что пользователь заказчик или исполнитель;
    private function check_user_role()
    {
        return $this->user_id === $this->customer_id or $this->user_id === $this->executor_id;
    }

    // Получаю доступные действия для указанного статуса;
    public function get_user_actions($current_status)
    {
        // if (!isset($this->get_statuses_map()[$current_status])) {
        //     throw new  StatusException('Задан невозможный статус');
        // }

        if ($this->check_user_role()) {
            $role = $this->user_id === $this->customer_id ? self::ROLE_CUSTOMER : self::ROLE_EXECUTOR;
            return new $this->next_action[$current_status][$role]($this->customer_id, $this->executor_id, $this->user_id);
        }
        return null;
    }
}
