<?php

namespace TaskForce\tasks;

use TaskForce\exceptions\StatusException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAILED = 'failed';
    const STATUS_FINISHED = 'finished';

    const ACTION_RESPOND = 'respond';
    const ACTION_START = 'start';
    const ACTION_REFUSED = 'refused';
    const ACTION_CANCELED = 'canceled';
    const ACTION_FINISHED = 'finished';

    public const ROLE_CUSTOMER = 0;
    public const ROLE_EXECUTOR = 1;

    /**
     * @param int $customer_id
     * @param int|null $executor_id
     * @param int $user_id
     * @param string $current_status
     */
    public function __construct(int $customer_id, int $executor_id = null, int $user_id, string $current_status)
    {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->user_id = $user_id;

        if (!isset($this->get_statuses_map()[$current_status])) {
            throw new  StatusException('Класс Task: нет такого статуса');
        }

        $this->current_status = $current_status;
    }

    /**
     * @return array
     */
    public function get_statuses_map(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_FINISHED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    /**
     * @return array
     */
    public function get_actions_map(): array
    {
        return [
            self::ACTION_RESPOND => 'Добавление отклика',
            self::ACTION_START => 'Старт задания',
            self::ACTION_REFUSED => 'Отказ от задания',
            self::ACTION_CANCELED => 'Отмена задания',
            self::ACTION_FINISHED => 'Завершение задания',
        ];
    }

    public $next_action = [
        self::STATUS_NEW => [
            self::ROLE_CUSTOMER => CancelAction::class,
            self::ROLE_EXECUTOR => RespondAction::class,
        ],
        self::STATUS_IN_PROGRESS => [
            self::ROLE_CUSTOMER => FinishAction::class,
            self::ROLE_EXECUTOR => RefuseAction::class,
        ],
        self::STATUS_CANCELED => [
            self::ROLE_CUSTOMER => OtherAction::class,
            self::ROLE_EXECUTOR => OtherAction::class,
        ],
        self::STATUS_FAILED => [
            self::ROLE_CUSTOMER => OtherAction::class,
            self::ROLE_EXECUTOR => OtherAction::class,
        ],
        self::STATUS_FINISHED => [
            self::ROLE_CUSTOMER => OtherAction::class,
            self::ROLE_EXECUTOR => OtherAction::class,
        ]
    ];

    /**
     * @param string $current_status
     * 
     * @return object
     */
    public function get_user_actions(string $current_status): object
    {
        $role = $this->user_id === $this->customer_id ? self::ROLE_CUSTOMER : self::ROLE_EXECUTOR;
        return new $this->next_action[$current_status][$role]($this->customer_id, $this->executor_id, $this->user_id);
    }
}
