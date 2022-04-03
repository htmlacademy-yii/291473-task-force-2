<?php

namespace app\models;

class Profiles extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'profiles';
    }

    public function rules()
    {
        return [
            [['about'], 'string'],
            [['average_rating'], 'number'],
            [['avatar_link', 'address', 'bd', 'phone', 'skype', 'messanger'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'about' => 'About',
            'avatar_link' => 'Avatar Link',
            'average_rating' => 'Average Rating',
            'address' => 'Address',
            'bd' => 'Bd',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
            'user_id' => 'User ID',
        ];
    }
}
