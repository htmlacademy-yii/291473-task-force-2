<?php

namespace app\models;

use yii\base\Model;

class SecuritynForm extends Model
{
    public $email;
    public $password;

    public $current_password;
    public $new_password;
    public $new_password_repeat;

    private $_user;

    public function rules()
    {
        return [
            [['current_password', 'new_password', 'new_password_repeat'], 'required'],
            [['current_password', 'new_password', 'new_password_repeat'], 'safe'],
            ['current_password', 'validatePassword'],
        ];
    }

    // public function getUser()
    // {
    //     if ($this->_user === null) {
    //         $this->_user = User::findOne(['email' => $this->email]);
    //     }

    //     return $this->_user;
    // }

    // public function validatePassword($attribute, $params)
    // {
    //     if (!$this->hasErrors()) {
    //         $user = User::findOne(['email' => $this->email])

    //         if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
    //             $this->addError($attribute, 'Неправильный email или пароль');
    //         }
    //     }
    // }
}
