<?php

namespace app\models;

class TasksFiles extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tasks_files';
    }

    public function rules()
    {
        return [
            [['task_id'], 'integer'],
            [['link'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'link' => 'Link',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
