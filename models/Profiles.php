<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string $address
 * @property string $bd
 * @property string|null $about
 * @property string $phone
 * @property string $skype
 * @property string|null $messanger
 * @property int|null $role
 * @property int|null $city_id
 * @property int|null $average_rating
 * @property string|null $avatar_link
 *
 * @property Cities $city
 * @property Replies[] $replies
 * @property Users[] $users
 * @property User[] $user
 * @property Specializations[] $Specializations
 * @property Tasks[] $executorTasks
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'bd', 'phone', 'skype'], 'required'],
            [['about'], 'string'],
            [['role', 'city_id', 'average_rating'], 'integer'],
            [['address', 'bd', 'phone', 'skype', 'messanger', 'avatar_link'], 'string', 'max' => 128],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
            'role' => 'Role',
            'city_id' => 'City ID',
            'average_rating' => 'Average Rating',
            'avatar_link' => 'Avatar Link',
        ];
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
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['profile_id' => 'id']);
    }

    /** Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Specializations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSpecializations()
    {
        return $this->hasMany(Specializations::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    // /**
    //  * Gets query for [[Opinions]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getOpinions()
    // {
    //     return $this->hasMany(Opinions::className(), ['executor_id' => 'id']);
    // }
}
