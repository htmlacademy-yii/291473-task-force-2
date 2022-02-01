<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $about
 * @property int|null $role
 * @property int|null $city_id
 * @property string|null $avatar_link
 * @property float|null $average_rating
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $messanger
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
            [['role', 'city_id'], 'integer'],
            [['average_rating'], 'number'],
            [['avatar_link', 'address', 'bd', 'phone', 'skype', 'messanger'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'about' => 'About',
            'role' => 'Role',
            'city_id' => 'City ID',
            'avatar_link' => 'Avatar Link',
            'average_rating' => 'Average Rating',
            'address' => 'Address',
            'bd' => 'Bd',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
        ];
    }
}
