<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TasksSearchForm;
use app\models\Tasks;
use app\models\Categories;
use TaskForce\utils\TasksFilter;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $model = new TasksSearchForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) {
                $tasks = (new TasksFilter())->getFilteredTasks($model);
            }
        }

        !isset($tasks) && $tasks = Tasks::find()->all();
        $categories = Categories::find()->all();

        return $this->render('index', [
            'model' => $model,
            'tasks' => $tasks,
            'categories' => $categories,
            'period_values' => TasksSearchForm::PERIOD_VALUES
        ]);
    }

    public function actionView(int $id)
    {
        $task = Tasks::find()
            ->joinWith('city', 'category')
            ->where(['tasks.id' => $id])
            ->one();
        
        $replies = [];

        if (!$task) {
            throw new NotFoundHttpException;
        }

        // $replies = Replies::find()
        // ->joinWith('profiles')
        // ->all();

        return $this->render('view', [
            'task' => $task,
            'replies' => $replies,
        ]);
    }
}
