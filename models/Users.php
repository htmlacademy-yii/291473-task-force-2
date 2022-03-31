<?php

namespace app\models;

class Users extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['email', 'name', 'password', 'dt_add'], 'required'],
            [['dt_add'], 'safe'],
            [['city_id', 'role'], 'integer'],
            [['email', 'name'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'dt_add' => 'Dt Add',
            'city_id' => 'City ID',
            'role' => 'Role',
            'id' => 'ID',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id']);
    }

    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    public function getExecutorTasks()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['executor_id' => 'id']);
    }

    public function getUsersSpecializations()
    {
        return $this->hasMany(Specializations::className(), ['user_id' => 'id']);
    }
}
