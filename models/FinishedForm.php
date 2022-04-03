<?php

namespace app\models;

use yii\base\Model;

class FinishedForm extends Model
{

    public $description;
    public $rating;

    public function rules()
    {
        return [
            [['description', 'rating'], 'required'],
            [['rating'], 'integer'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'description' => 'Опишите, как справился исполнитель:',
            'rating' => 'Оцените работу от 1 до 5',
        ];
    }
}
