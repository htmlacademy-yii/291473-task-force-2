<?php

namespace app\models;

use yii\base\Model;
use app\models\Cities;
use app\models\Users;

class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $city_id;
    public $password;
    public $password_repeat;
    public $role;

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'password_repeat'], 'trim'],
            [['name', 'email', 'city_id', 'password', 'password_repeat'], 'required'],
            [['email'], 'string', 'max' => 128],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => Users::class],
            [['name'], 'string', 'length' => [1, 128]], //2
            [['password'], 'string', 'length' => [1, 255]], //6
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'targetClass' => Cities::class, 'targetAttribute' => 'id'],
            [['role'], 'boolean'] // или все же использовать int 1/0?
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city_id' => 'Город',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'role' => 'Я собираюсь откликаться на заказы'
        ];
    }
}
