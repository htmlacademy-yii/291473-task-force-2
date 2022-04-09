<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property string|null $about
 * @property string|null $avatar_link
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $messanger
 * @property int $user_id
 * @property int|null $average_rating
 * @property int|null $filed_tasks
 * @property int $id
 * @property int $private
 *
 * @property Users $user
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
            [['about'], 'string'],
            [['user_id'], 'required'],
            [['user_id', 'average_rating', 'filed_tasks', 'private'], 'integer'],
            [['avatar_link', 'address', 'bd', 'phone', 'skype', 'messanger'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'about' => 'About',
            'avatar_link' => 'Avatar Link',
            'address' => 'Address',
            'bd' => 'Bd',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
            'user_id' => 'User ID',
            'average_rating' => 'Average Rating',
            'filed_tasks' => 'Filed Tasks',
            'id' => 'ID',
            'private' => 'Private',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
