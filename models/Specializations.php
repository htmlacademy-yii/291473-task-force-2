<?php

namespace app\models;

class Specializations extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'specializations';
    }

    public function rules()
    {
        return [
            [['user_id', 'specialization_id'], 'required'],
            [['user_id', 'specialization_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['specialization_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'specialization_id' => 'Specialization ID',
        ];
    }

    public function getSpecialization()
    {
        return $this->hasOne(Categories::className(), ['id' => 'specialization_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'user_id']);
    }
}
