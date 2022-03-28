<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\TasksService;
use yii\data\Pagination;

class MytasksController extends Controller
{
    public function actionIndex()
    {
        $userId = Yii::$app->user->getId();
        $tasks_filter = Yii::$app->request->get('tasks_filter');
        $query = (new TasksService())->getMyTasksByStatus($tasks_filter, $userId);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $myTasks = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'myTasks' => $myTasks,
            'pages' => $pages,
            'tasks_filter' => $tasks_filter,
        ]);
    }
}
