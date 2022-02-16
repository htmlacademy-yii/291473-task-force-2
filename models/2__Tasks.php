<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $dt_add
 * @property int $category_id
 * @property string|null $description
 * @property string $deadline срок выполнения задания
 * @property string $fin_date фактический срок выполнения задания
 * @property string $name
 * @property string $address
 * @property int $budget
 * @property string $latitude
 * @property string $longitude
 * @property int $customer_id заказчик
 * @property int $executor_id исполнитель
 * @property int $city_id город
 * @property string $file_link
 * @property string $status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add', 'category_id', 'deadline', 'fin_date', 'name', 'address', 'budget', 'latitude', 'longitude', 'customer_id', 'executor_id', 'city_id', 'file_link', 'status'], 'required'],
            [['dt_add', 'deadline', 'fin_date'], 'safe'],
            [['category_id', 'budget', 'customer_id', 'executor_id', 'city_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'address', 'latitude', 'longitude', 'file_link', 'status'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'deadline' => 'Deadline',
            'fin_date' => 'Fin Date',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'city_id' => 'City ID',
            'file_link' => 'File Link',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }
}
