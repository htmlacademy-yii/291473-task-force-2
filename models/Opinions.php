<?php

namespace app\models;

class Opinions extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'opinions';
    }

    public function rules()
    {
        return [
            [['dt_add', 'rate', 'customer_id', 'executor_id', 'task_id', 'rating'], 'required'],
            [['dt_add'], 'safe'],
            [['rate', 'customer_id', 'executor_id', 'task_id', 'rating'], 'integer'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'description' => 'Description',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
            'rating' => 'Rating',
            'id' => 'ID',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'customer_id']);
    }
}
