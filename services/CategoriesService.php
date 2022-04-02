<?php

namespace app\services;

use app\models\Categories;

class CategoriesService
{
    /**
     * @return array
     */
    public function findAll(): array
    {
        return Categories::find()->all();
    }
}
