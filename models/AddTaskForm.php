<?php

namespace app\models;

use yii\base\Model;
use app\models\Categories;
use app\models\Cities;

class AddTaskForm extends Model
{
    public $name;
    public $description;
    public $category_id;
    public $location;
    public $latitude;
    public $longitude;
    public $city_name;
    public $address;
    public $budget;
    public $deadline;
    public $files;

    public function rules()
    {
        return [
            [['name', 'description'], 'trim'],
            [['name', 'description', 'category_id'], 'required'],
            [['name'], 'string', 'length' => [10, 128]],
            [['description'], 'string', 'length' => [30, 255]],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'targetClass' => Categories::class, 'targetAttribute' => 'id'],
            [['location', 'city_name'], 'string'],
            [['address'], 'string'],
            [['latitude', 'longitude'], 'string'],
            [
                ['city_name'], 'exist', 'targetClass' => Cities::class, 'targetAttribute' => 'city',
                'message' => 'Название города не найдено в таблице городов'
            ],
            [['budget'], 'integer', 'min' => 1],
            [
                ['deadline'], 'date', 'format' => 'php:Y-m-d', 'min' => strtotime('today'),
                'tooSmall' => 'Дата не может быть раньше текущего дня.'
            ],
            [['files'], 'file', 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
            'files' => 'Добавить новый файл',
        ];
    }
}
