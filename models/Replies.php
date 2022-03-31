<?php

namespace app\models;

class Replies extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'replies';
    }

    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['rate'], 'required'],
            [['rate', 'executor_id', 'task_id'], 'integer'],
            [['description'], 'string'],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['executor_id' => 'user_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'description' => 'Description',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getExecutor()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'executor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    public function getOpinion()
    {
        return $this->hasMany(Opinions::className(), ['executor_id' => 'executor_id']);
    }
}
