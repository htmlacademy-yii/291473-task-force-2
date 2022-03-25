<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SecurityForm extends Model
{
    public $current_password;
    public $new_password;
    public $new_password_repeat;

    public function rules()
    {
        return [
            [['current_password', 'new_password', 'new_password_repeat'], 'required'],
            [['current_password', 'new_password', 'new_password_repeat'], 'safe'],
            ['current_password', 'validateCurrentPassword'],
            ['new_password', 'validatePassword'],
            ['new_password', 'validateNewPassword'],
            ['new_password_repeat', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Повтор нового пароля'
        ];
    }

    public function validateCurrentPassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['id' => Yii::$app->user->getId()]);
            if (!$user || !$user->validatePassword($this->current_password)) {
                $this->addError($attribute, 'Неправильный пароль');
            }
        }
    }

    public function validatePassword($attribute)
    {
        if ($this->new_password !== $this->new_password_repeat) {
            $this->addError($attribute, 'Пароли не совпадают');
        }
    }

    public function validateNewPassword($attribute)
    {
        if ($this->new_password === $this->current_password) {
            $this->addError($attribute, 'Ваш текущий и новый пароль совпадают');
        }
    }
}
