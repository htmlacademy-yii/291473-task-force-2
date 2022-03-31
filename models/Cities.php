<?php

namespace app\models;

class Cities extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cities';
    }

    public function rules()
    {
        return [
            [['city', 'latitude', 'longitude'], 'required'],
            [['city', 'latitude', 'longitude'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['city_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['city_id' => 'id']);
    }
}
