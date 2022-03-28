<?php

namespace app\models;

use yii\base\Model;
use app\models\Categories;

class EditProfileForm extends Model
{
    public $avatar;
    public $name;
    public $email;
    public $bd;
    public $phone;
    public $messanger;
    public $about;
    public $categories;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['avatar'], 'image', 'extensions' => 'png, jpg'],
            [['name'], 'string', 'length' => [2, 128]],
            [['email', 'about'], 'string', 'max' => 128],
            [['email'], 'email'],
            [
                ['bd'], 'date', 'format' => 'php:Y-m-d', 'max' => strtotime('today'),
                'tooBig' => 'Дата не может быть позже текущего дня'
            ],
            [['about', 'bd', 'phone', 'messanger'], 'default', 'value' => null],
            [['phone'], 'string', 'length' => [11, 11]],
            [['messanger'], 'string', 'max' => 64],
            [['categories'], 'default', 'value' => []],
            [['categories'], 'exist', 'targetClass' => Categories::class, 'targetAttribute' => 'id', 'allowArray' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'bd' => 'День рождения',
            'phone' => 'Номер телефона',
            'messanger' => 'Telegram',
            'about' => 'Информация о себе',
            'categories' => 'Выбор специализаций',
        ];
    }
}
