<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SecurityForm extends Model
{
    public $private;
    public $current_password;
    public $new_password;
    public $new_password_repeat;

    public function rules()
    {
        return [
            [['private'], 'boolean'],
            [['current_password'], 'required'],
            [['current_password'], 'string', 'length' => [6, 128]],
            [['current_password'], 'validateCurrentPassword'],
            [
                ['new_password'], 'required',
                'whenClient' => "function (attribute, value) {
                    return $('#securityform-current_password').value;
                }"
            ],
            [
                ['new_password'], 'string', 'length' => [6, 128],
                'whenClient' => "function (attribute, value) {
                    return !$('#securityform-current_password').attr('aria-invalid');
                }"
            ],

            [
                ['new_password_repeat'], 'required',
                'whenClient' => "function (attribute, value) {
                return $('#securityform-new_password').value;
                }"
            ],
            [
                ['new_password_repeat'], 'compare', 'compareAttribute' => 'new_password',
                'whenClient' => "function (attribute, value) {
                return !$('#securityform-new_password').attr('aria-invalid');
                }"
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Повтор нового пароля',
            'private' => 'Скрывать контактные данные',
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
}
