<?php

namespace app\models;

class Tasks extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            [['dt_add', 'category_id', 'name', 'customer_id'], 'required'],
            [['dt_add', 'deadline', 'fin_date'], 'safe'],
            [['category_id', 'customer_id', 'budget', 'executor_id', 'city_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'address', 'latitude', 'longitude', 'status'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'name' => 'Name',
            'customer_id' => 'Customer ID',
            'deadline' => 'Deadline',
            'fin_date' => 'Fin Date',
            'address' => 'Address',
            'budget' => 'Budget',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'status' => 'Status',
            'executor_id' => 'Executor ID',
            'city_id' => 'City ID',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }
}
