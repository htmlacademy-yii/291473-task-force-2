<?php

namespace app\controllers;

use app\models\Categories;
use app\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $query = Tasks::find()
            ->joinWith('category')
            ->where(['status' => '1'])
            ->orderBy('dt_add DESC');

        $tasks = $query->all();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
