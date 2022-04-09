<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specializations".
 *
 * @property int $id
 * @property int $specialization_user_id
 * @property int $specialization_id
 *
 * @property Categories $specialization
 * @property Users $specializationUser
 */
class Specializations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specializations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['specialization_user_id', 'specialization_id'], 'required'],
            [['specialization_user_id', 'specialization_id'], 'integer'],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['specialization_id' => 'id']],
            [['specialization_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['specialization_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specialization_user_id' => 'Specialization User ID',
            'specialization_id' => 'Specialization ID',
        ];
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(Categories::className(), ['id' => 'specialization_id']);
    }

    /**
     * Gets query for [[SpecializationUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecializationUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'specialization_user_id']);
    }
}
