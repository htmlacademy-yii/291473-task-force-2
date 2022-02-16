<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Replies;
use app\models\AddTaskForm;
use TaskForce\utils\CustomHelpers;

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

        // $task->executor_id = '2'; // Временная заглушка;

        // 'id' => 'ID', +

        // 'dt_add' => 'Dt Add', +
        $task->dt_add = CustomHelpers::getCurrentDate();

        // 'category_id' => 'Category ID', +
        $task->category_id = $addTaskFormModel->category_id;

        // 'description' => 'Description', +
        $task->description = $addTaskFormModel->description;

        // 'deadline' => 'deadline', +
        $task->deadline = $addTaskFormModel->deadline;

        // 'name' => 'Name',
        $task->name = $addTaskFormModel->name;

        // 'address' => 'Address', +
        $task->address = $addTaskFormModel->location; // Проверить, это город???

        // 'budget' => 'Budget', +
        $task->budget = $addTaskFormModel->budget;

        // 'latitude' => 'Latitude', +
        $task->latitude = '123'; // Временная заглушка;

        // 'longitude' => 'Longitude', +
        $task->latitude = '123'; // Временная заглушка;

        // 'status' => 'Status', +
        $task->status = 'new';

        // 'customer_id' => 'Customer ID',
        $task->customer_id = Yii::$app->user->id;

        // 'executor_id' => 'Executor ID',
        $task->executor_id = '2';

        // 'city_id' => 'City ID',
        $task->city_id = '1'; // Временная заглушка;

        // 'file_link' => 'File Link',
        $task->file_link = 'abc'; // Временная заглушка;

        // $this->upload($addTaskFormModel, $task->id);

        $task->save();

        // $task_id = $task->id;

        return 1;
    }
}
