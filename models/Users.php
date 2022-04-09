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
 * @property int|null $role
 * @property int $id
 * @property int|null $city_id
 *
 * @property Auth[] $auths
 * @property Cities $city
 * @property Opinions[] $opinions
 * @property Opinions[] $opinions0
 * @property Profiles[] $profile
 * @property Replies[] $replies
 * @property Specializations[] $usersSpecializations
 * @property Tasks[] $customerTasks
 * @property Tasks[] $executorTasks
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
            [['role', 'city_id'], 'integer'],
            [['email', 'name'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'role' => 'Role',
            'id' => 'ID',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[Auths]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['auth_user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['opinion_customer_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions0()
    {
        return $this->hasMany(Opinions::className(), ['opinion_executor_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['reply_executor_id' => 'id']);
    }

    /**
     * Gets query for [[UsersSpecializations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSpecializations()
    {
        return $this->hasMany(Specializations::className(), ['specialization_user_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }
}
