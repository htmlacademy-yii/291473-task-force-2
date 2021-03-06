<?php

namespace app\models;

use yii\base\Model;

class RefuseForm extends Model
{
    public $dt_add;
    public $description;

    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dt_add' => 'Dt Add',
            'description' => 'Укажите комментарий:',
        ];
    }
}
