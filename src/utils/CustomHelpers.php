<?php

declare(strict_types=1);
namespace TaskForce\utils;

class CustomHelpers {

    /**
     * Возвращает разницу в годах
     * @param string $birthday дата в стоковом формате
     *
     * @return int разница в годах
    */
    public static function getUserAge($birthday): int
    {
        $birthdayDate = getdate(strtotime($birthday));
        $currentDate = getdate();

        return $currentDate['year'] - $birthdayDate['year'];
    }

    public static function getTasksCount($tasks): array
    {
        $finishedCount = 0;
        $faledCount = 0;

        foreach ($tasks as $task) {
            if ($task->status === 'finished') {
                $finishedCount++;
            }
    
            if ($task->status === 'failed') {
                $faledCount++;
            }
        } 

        $array = ["$finishedCount", "$faledCount"];
        return $array;

    }

    /**
     * Возвращает текстовый статус пользователя
     * @param int $tasks массив со списком задач, в которых пользователя является исполнителем
     *
     * @return string статус пользователя в текстовом формате
    */
    public static function getUserStatus($tasks): string
    {
        foreach ($tasks as $task) {
            if ($task->status === 'new' || 'in_progress') {
                return "Сейчас выполняет заказ";
            }
        } 

        return "Открыт для новых заказов";
    }


}