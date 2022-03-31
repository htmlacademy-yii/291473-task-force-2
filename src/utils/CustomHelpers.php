<?php

declare(strict_types=1);

namespace TaskForce\utils;

use Yii;
use app\models\Profiles;
use app\models\User;
use yii\db\Expression;

const ALL_STARS_COUNT = 5;
const COUNT_BYTES_IN_KILOBYTE = 1024;

class CustomHelpers
{
    /**
     * @param int $fullStarsCount
     * 
     * @return string
     */
    public static function getRatingStars(int $fullStarsCount): string
    {
        $allStars = '';
        $emptyStarsCount = ALL_STARS_COUNT - floor($fullStarsCount);

        while ($fullStarsCount > 0) {
            $fullStarsCount--;
            $allStars .= "<span class=\"fill-star\">&nbsp;</span>";
        }

        while ($emptyStarsCount > 0) {
            $emptyStarsCount--;
            $allStars .= "<span>&nbsp;</span>";
        }

        return $allStars;
    }

    /**
     * @param string $birthday
     * 
     * @return int
     */
    public static function getTimeDifference(string $birthday): int
    {
        $birthdayDate = getdate(strtotime($birthday));
        $currentDate = getdate();

        return $currentDate['year'] - $birthdayDate['year'];
    }

    /**
     * @param string $date
     * 
     * @return string
     */
    public static function getRuDate(string $date): string
    {
        $dateTime = new \DateTime($date);
        $index = $dateTime->format('n') - 1;
        $months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Майя', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        return $dateTime->format("d $months[$index] Y, H:i");
    }

    /**
     * @param array $tasks
     * 
     * @return string
     */
    public static function getUserStatus(array $tasks): string
    {
        foreach ($tasks as $task) {
            if ($task->status === 'new' || 'in_progress') {
                return "Сейчас выполняет заказ";
            }
        }

        return "Открыт для новых заказов";
    }

    /**
     * @param string $taskStatus
     * 
     * @return string
     */
    public static function getTaskStatusName(string $taskStatus): string
    {
        $taskStatusesMap = [
            'new' => 'Новое',
            'in_progress' => 'В работе',
            'canceled' => 'Отменено',
            'failed' => 'Провалено',
            'finished' => 'Выполнено',
        ];

        return $taskStatusesMap[$taskStatus];
    }

    /**
     * @return object|null
     */
    public static function checkAuthorization(): ?object
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        return User::findIdentity(Yii::$app->user->getId());
    }

    /**
     * @param mixed $userId
     * 
     * @return object|null
     */
    public static function getUserProfile($userId): ?object
    {
        return Profiles::find()
            ->where(['user_id' => $userId])
            ->one();
    }

    /**
     * @return string
     */
    public static function getCurrentDate(): string
    {
        $expression = new Expression('NOW()');
        $now = (new \yii\db\Query)->select($expression)->scalar();
        return $now;
    }

    /**
     * @param mixed $date
     * 
     * @return string
     */
    public static function checkNullDate($date): string
    {
        if (isset($date)) {
            return date("j F Y, g:i a", strtotime($date));
        } else {
            return 'Время не задано';
        }
    }

    /**
     * @param string $file_path
     * 
     * @return float
     */
    public static function getFileSize(string $file_path): float
    {
        $fileSize = filesize(Yii::getAlias('@webroot') . '/uploads/' . $file_path) / COUNT_BYTES_IN_KILOBYTE;

        return ceil($fileSize);
    }

    /**
     * @param array $replies
     * @param object $task
     * @param int $userId
     * 
     * @return int
     */
    public static function checkCustomerOrExecutor(array $replies, object $task, int $userId): ?int
    {
        if (count($replies) > 0) {
            if ($task['customer_id'] === $userId) {
                return $userId;
            }
            foreach ($replies as $reply) {
                if ($reply['executor_id'] === $userId) {
                    return $userId;
                }
            }
        }
        return false;
    }

    /**
     * @param array $replies
     * 
     * @return bool
     */
    public static function checkRepliesStatus(array $replies): bool
    {
        foreach ($replies as $reply) {
            if ($reply['status'] === 1) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $replies
     * @param int $userId
     * 
     * @return bool
     */
    public static function checkExecutorAccess(array $replies, int $userId): bool
    {
        foreach ($replies as $reply) {
            if ($reply['executor_id'] === $userId) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $allExecutorTasks
     * 
     * @return bool
     */
    public static function checkCustomerAccess($allExecutorTasks): bool
    {
        foreach ($allExecutorTasks as $executorTask) {
            if ($executorTask->customer_id === Yii::$app->user->getId()) {
                return true;
            }
        }
        return false;
    }
}
