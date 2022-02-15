<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Replies;
use app\models\AddTaskForm;
use yii\db\Expression;

class TasksService
{

    public function getTask($id)
    {
        return Tasks::find()
            ->joinWith('city', 'category')
            ->where(['tasks.id' => $id])
            ->one();
    }

    public function getReplies($id)
    {
        return Replies::find()
            ->joinWith('executor', 'opinion')
            ->where(['replies.task_id' => $id])
            ->all();
    }

    public function createTask(AddTaskForm $addTaskFormModel)
    {
        $task = new Tasks;
        $expression = new Expression('NOW()'); // Вынести в хелпер!!!
        $now = (new \yii\db\Query)->select($expression)->scalar();  // ВЫБРАТЬ СЕЙЧАС ();

        $task->dt_add = $now;
        $task->category_id = $addTaskFormModel->category_id;
        $task->description = $addTaskFormModel->description;
        $task->deadline = $addTaskFormModel->deadline;
        $task->name = $addTaskFormModel->name;
        $task->address = $addTaskFormModel->location; // Проверить, это город???
        $task->budget = $addTaskFormModel->budget;
        $task->latitude = '123'; // Временная заглушка;
        $task->latitude = '123'; // Временная заглушка;
        $task->status = 'new';
        $task->customer_id = Yii::$app->user->id;
        // $task->executor_id = '2'; // Временная заглушка;
        $task->city_id = '1'; // Временная заглушка;
        $task->file_link = 'abc'; // Временная заглушка;


        $task_id = $task->id;

        $task->save();
        // $this->upload($addTaskFormModel, $task->id);

        return $task_id;

        // Tasks Model
        // 'id' => 'ID', +
        // 'dt_add' => 'Dt Add', +
        // 'category_id' => 'Category ID', +
        // 'description' => 'Description', +
        // 'expire' => 'Expire', +
        // 'name' => 'Name',
        // 'address' => 'Address', +
        // 'budget' => 'Budget', +
        // 'latitude' => 'Latitude', +
        // 'longitude' => 'Longitude', +
        // 'status' => 'Status', +
        // 'customer_id' => 'Customer ID',
        // 'executor_id' => 'Executor ID',
        // 'city_id' => 'City ID',
        // 'file_link' => 'File Link',

        // AddTaskForm Model
        // 'name' => 'Опишите суть работы',
        // 'description' => 'Подробности задания',
        // 'category_id' => 'Категория',
        // 'location' => 'Локация',
        // 'budget' => 'Бюджет',
        // 'expire' => 'Срок исполнения',
        // 'files' => 'Добавить новый файл',
    }
}
