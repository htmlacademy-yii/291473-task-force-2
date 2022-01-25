<?php

declare(strict_types=1);
namespace TaskForce\utils;

const ALL_STARS_COUNT = 5;

class RatingStars
{

    public static function getRatingStars(int $fullStarsCount){
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
}

