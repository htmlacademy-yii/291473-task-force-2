<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Replies;
use app\models\AddTaskForm;
use app\models\TasksFiles;
use app\models\Cities;
use TaskForce\utils\CustomHelpers;
use yii\db\Expression;

class TasksService
{
    /**
     * @param int $id
     * 
     * @return Tasks|null
     */
    public function getTask(int $id): ?Tasks
    {
        return Tasks::find()
            ->joinWith('city', 'category')
            ->where(['tasks.id' => $id])
            ->one();
    }

    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function getTasksByExecutor(int $id): ?array
    {
        return Tasks::find()
            ->where(['tasks.executor_id' => $id])
            ->andWhere(['tasks.status' => 'in_progress'])
            ->all();
    }

    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function getTaskFiles(int $id): ?array
    {
        return TasksFiles::find()
            ->where(['task_id' => $id])
            ->all();
    }

    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function getReplies(int $id): ?array
    {
        return Replies::find()
            ->joinWith('executor', 'user') //opinion
            ->where(['replies.task_id' => $id])
            ->all();
    }

    /**
     * @param AddTaskForm $addTaskFormModel
     * 
     * @return int
     */
    public function createTask(AddTaskForm $addTaskFormModel): int
    {
        $task = new Tasks;

        $task->name = $addTaskFormModel->name;
        $task->description = $addTaskFormModel->description;
        $task->category_id = $addTaskFormModel->category_id;
        $task->customer_id = Yii::$app->user->id;
        $task->status = 'new';
        $task->dt_add = CustomHelpers::getCurrentDate();
        $task->deadline = $addTaskFormModel->deadline;
        $task->budget = $addTaskFormModel->budget;

        $city = Cities::find()
            ->where(['cities.city' => $addTaskFormModel->city_name])
            ->one();

        if (isset($city)) {
            $task->city_id = $city['id'];
            $task->address = $addTaskFormModel->address;
            $task->latitude = $addTaskFormModel->latitude;
            $task->longitude = $addTaskFormModel->longitude;
        }

        $task->save();
        $task_id = $task->id;

        foreach ($addTaskFormModel->files as $file) {
            $file_path = uniqid('file_') . '.' . $file->extension;
            $file->saveAs(Yii::getAlias('@webroot') . '/uploads/' . $file_path);

            $task_file = new TasksFiles;
            $task_file->link = $file_path;
            $task_file->task_id = $task_id;
            $task_file->save();
        }

        return $task_id;
    }

    /**
     * @param string|null $tasks_filter
     * @param int $userId
     * 
     * @return object|null
     */
    public function getMyTasksByStatus(?string $tasks_filter, int $userId): ?object
    {
        if (Yii::$app->user->identity->role === 0) {
            $query = Tasks::find()->where(['customer_id' => $userId]);

            switch ($tasks_filter) {
                case 'new':
                    $query->andWhere(['status' => 'new']);
                    break;

                case 'in_progress':
                    $query->andWhere(['status' => 'in_progress']);
                    break;

                case 'closed':
                    $statuses = ['failed', 'canceled', 'finished'];
                    $query->andWhere(['in', 'status', $statuses]);
                    break;
            }
        } else {
            $query = Tasks::find()->where(['executor_id' => $userId]);

            switch ($tasks_filter) {
                case 'in_progress':
                    $query->andWhere(['status' => 'in_progress']);
                    break;

                case 'overdue':
                    $query
                        ->andWhere(['status' => 'in_progress'])
                        ->andWhere(['<', 'tasks.deadline', new Expression('NOW()')]);
                    break;

                case 'closed':
                    $statuses = ['failed', 'finished'];
                    $query->andWhere(['in', 'status', $statuses]);
                    break;
            }
        }

        return $query;
    }
}
