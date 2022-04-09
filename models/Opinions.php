<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opinions".
 *
 * @property string $dt_add
 * @property int $rate
 * @property string|null $description
 * @property int $rating
 * @property int $id
 * @property int $opinion_customer_id
 * @property int $opinion_executor_id
 * @property int $opinion_task_id
 *
 * @property Users $opinionCustomer
 * @property Users $opinionExecutor
 * @property Tasks $task
 * @property Profiles $profile
 */
class Opinions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add', 'rate', 'rating', 'opinion_customer_id', 'opinion_executor_id', 'opinion_task_id'], 'required'],
            [['dt_add'], 'safe'],
            [['rate', 'rating', 'opinion_customer_id', 'opinion_executor_id', 'opinion_task_id'], 'integer'],
            [['description'], 'string'],
            [['opinion_customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['opinion_customer_id' => 'id']],
            [['opinion_executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['opinion_executor_id' => 'id']],
            [['opinion_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['opinion_task_id' => 'id']],
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
            'rating' => 'Rating',
            'id' => 'ID',
            'opinion_customer_id' => 'Opinion Customer ID',
            'opinion_executor_id' => 'Opinion Executor ID',
            'opinion_task_id' => 'Opinion Task ID',
        ];
    }

    /**
     * Gets query for [[OpinionCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinionCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'opinion_customer_id']);
    }

    /**
     * Gets query for [[OpinionExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinionExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'opinion_executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'opinion_task_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'opinion_customer_id']);
    }
}
