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
}