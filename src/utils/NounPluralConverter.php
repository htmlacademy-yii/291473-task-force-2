<?php

declare(strict_types=1);

namespace TaskForce\utils;

class NounPluralConverter
{
    //* Возвращает корректную форму множественного числа;

    public static function getNounPluralForm(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 20):
                return $many;

            case ($mod10 > 5):
                return $many;

            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    /**
     * Получает разницу между временем постановки задачи и текущем временем;
     * @param string дата в текстовом формате
     *
     * @return string возвращает текстовое значение - сколько времени прошло с момента постановки задачи;
     */

    public static function getTaskRelativeTime(string $dt_add): string
    {
        $addTimeMark = strtotime($dt_add);
        $nowTimeArray = getdate();
        $addTimeArray = getdate($addTimeMark);

        $years = $nowTimeArray['year'] - $addTimeArray['year'];
        $months = $nowTimeArray['mon'] - $addTimeArray['mon'];
        $days = $nowTimeArray['mday'] - $addTimeArray['mday'];
        $hours = $nowTimeArray['hours'] - $addTimeArray['hours'];
        $minutes = $nowTimeArray['minutes'] - $addTimeArray['minutes'];

        if ($years > 0) {
            return $years . " " . self::getNounPluralForm($years, "год", "года", "лет") . " назад";
        }
        if ($months > 0 || $days > 1) {
            return date("d.m.Y в H:i", $addTimeMark);
        } elseif ($days === 1) {
            return date("вчера, в H:i", $addTimeMark);
        } elseif ($hours > 1) {
            return date("в H:i", $addTimeMark);
        } elseif ($hours === 1) {
            return date("час назад");
        }
        if ($minutes === 0) {
            return "меньше минуты назад";
        }
        return $minutes . " " . self::getNounPluralForm($minutes, "минута", "минуты", "минут") . " назад";
    }

    public static function getOpinionsTitle($opinions_count)
    {
        return self::getNounPluralForm($opinions_count, "отзыв", "отзыва", "отзывов");
    }
}
