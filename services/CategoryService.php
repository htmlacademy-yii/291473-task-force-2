<?php

namespace app\services;

use app\models\Categories;

class CategoryService
{
    public function getAllCategories(): array
    {
        return Categories::find()->all();
    }

    public function getCategoryIds(): array
    {
        return Categories::find()->column();
    }
}
