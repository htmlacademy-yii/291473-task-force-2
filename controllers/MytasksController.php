<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use TaskForce\utils\CustomHelpers;
use app\models\Tasks;
use app\services\TasksService;


class MytasksController extends Controller
{
    public function actionIndex()
    {
        $tasks_filter = Yii::$app->request->get('tasks_filter');
        $myTasks = (new TasksService())->getMyTasksByStatus($tasks_filter);

        return $this->render('index', [
            'myTasks' => $myTasks,
            'tasks_filter' => $tasks_filter,
        ]);
    }
}
