<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\TasksService;
use yii\data\ActiveDataProvider;

class MytasksController extends Controller
{
    public function actionIndex()
    {
        $userId = Yii::$app->user->getId();
        $tasks_filter = Yii::$app->request->get('tasks_filter');
        $query = (new TasksService())->getMyTasksByStatus($tasks_filter, $userId);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'dt_add' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tasks_filter' => $tasks_filter,
        ]);
    }
}
