<?php

declare(strict_types=1);

namespace TaskForce\utils;
const ALL_STARS_COUNT = 5;

class CustomHelpers
{
    /**
     * Возвращает текст-верстку звездочек рейтинга
     * @param int $fullStarsCount рейтинг пользователя в числовом формате
     *
     * @return string верстка звездочек для отображения на странице
     */
    public static function getRatingStars(int $fullStarsCount): string
    {
        $allStars = '';
        $emptyStarsCount = ALL_STARS_COUNT - floor($fullStarsCount);

        while($fullStarsCount > 0) {
            $fullStarsCount--;
            $allStars .= "<span class=\"fill-star\">&nbsp;</span>";
        }

        while($emptyStarsCount > 0) {
            $emptyStarsCount--;
            $allStars .= "<span>&nbsp;</span>";
        }

        return $allStars;
    }

    /**
     * Возвращает разницу в годах
     * @param string $birthday дата в стоковом формате
     *
     * @return int разница в годах
     */
    public static function getTimeDifference ($birthday): int
    {
        $birthdayDate = getdate(strtotime($birthday));
        $currentDate = getdate();

        return $currentDate['year'] - $birthdayDate['year'];
    }

    public static function getTasksCount($tasks): array
    {
        $finishedCount = 0;
        $failedCount = 0;

        foreach ($tasks as $task) {
            if ($task->status === 'finished') {
                $finishedCount++;
            }

            if ($task->status === 'failed') {
                $failedCount++;
            }
        }

        return [$finishedCount, $failedCount];
    }

    /**
     * Возвращает дату в формате: день / месяц / год / время
     *
     * @param string $date дата в текстовом формате
     *
     * @return string дата в формате день, месяц (на русском языке), год и время
    */
    public static function getRuDate($date): string
    {
        $dateTime = new \DateTime($date);
        $index = $dateTime->format('n') - 1;
        $months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Майя', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        return $dateTime->format("d $months[$index] Y, H:i");
    }

    /**
     * Возвращает текстовый статус пользователя
     * @param array $tasks массив со списком задач, в которых пользователя является исполнителем
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
