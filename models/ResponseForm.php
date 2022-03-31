<?php

namespace app\models;

use yii\base\Model;

class ResponseForm extends Model
{
    public $description;
    public $rate;

    public static function tableName()
    {
        return 'replies';
    }

    public function rules()
    {
        return [

            [['rate'], 'required'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rate' => 'Ваша цена:',
            'description' => 'Комментарий:',
        ];
    }
}
