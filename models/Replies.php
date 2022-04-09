<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "replies".
 *
 * @property string $dt_add
 * @property int $rate
 * @property string|null $description
 * @property int $id
 * @property int|null $status
 * @property int $reply_executor_id
 * @property int $reply_task_id
 *
 * @property Users $user
 * @property Tasks $task
 * @property Profiles $executor
 * @property Opinions $opinion
 */
class Replies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add', 'rate', 'reply_executor_id', 'reply_task_id'], 'required'],
            [['dt_add'], 'safe'],
            [['rate', 'status', 'reply_executor_id', 'reply_task_id'], 'integer'],
            [['description'], 'string'],
            [['reply_executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['reply_executor_id' => 'id']],
            [['reply_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['reply_task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'description' => 'Description',
            'id' => 'ID',
            'status' => 'Status',
            'reply_executor_id' => 'Reply Executor ID',
            'reply_task_id' => 'Reply Task ID',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'reply_executor_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'reply_executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'reply_task_id']);
    }

    /**
     * Gets query for [[Opinion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinion()
    {
        return $this->hasMany(Opinions::className(), ['opinion_executor_id' => 'reply_executor_id']);
    }
}
