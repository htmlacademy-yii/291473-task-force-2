<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $dt_add
 * @property int $profile_id
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'dt_add'], 'required'],
            [['dt_add'], 'safe'],
            [['email', 'name'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'dt_add' => 'Dt Add',
            'profile_id' => 'Profile ID',
        ];
    }
}
