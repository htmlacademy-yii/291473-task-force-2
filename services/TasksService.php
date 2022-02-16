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

        $task->name = $addTaskFormModel->name;
        $task->description = $addTaskFormModel->description;
        $task->category_id = $addTaskFormModel->category_id;
        $task->customer_id = Yii::$app->user->id;
        $task->status = 'new';
        $task->dt_add = CustomHelpers::getCurrentDate();
        $task->save();

        $task_id = $task->id;
        return $task_id;

        // // $task->executor_id = '2'; // Временная заглушка;
        // // 'id' => 'ID', +

        // // 'deadline' => 'deadline', +
        // $task->deadline = $addTaskFormModel->deadline;

        // // 'address' => 'Address', +
        // $task->address = $addTaskFormModel->location; // Проверить, это город???

        // // 'budget' => 'Budget', +
        // $task->budget = $addTaskFormModel->budget;

        // // 'latitude' => 'Latitude', +
        // $task->latitude = '123'; // Временная заглушка;

        // // 'longitude' => 'Longitude', +
        // $task->latitude = '123'; // Временная заглушка;

        // // 'executor_id' => 'Executor ID',
        // $task->executor_id = '2';

        // // 'city_id' => 'City ID',
        // $task->city_id = '1'; // Временная заглушка;

        // // 'file_link' => 'File Link',
        // $task->file_link = 'abc'; // Временная заглушка;

        // // $this->upload($addTaskFormModel, $task->id);

        // print($task->id);
        // print_r($task);
    }
}
