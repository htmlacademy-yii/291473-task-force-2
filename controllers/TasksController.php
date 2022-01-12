<?php

namespace app\controllers;

use app\models\Tasks;
use yii\web\Controller;


use app\models\Contact;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\Response;




class TasksController extends Controller
{
    public function actionIndex()
    {
        $query = Tasks::find()
            ->where(['status' => NULL])
            ->orderBy('dt_add DESC');

        $tasks = $query->all();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
