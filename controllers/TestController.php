<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\TestForm;

class TestController extends Controller
{
    public function actionPage()
    {
        $form_model = new TestForm();
        if ($form_model->load(\Yii::$app->request->post())) {
            var_dump(\Yii::$app->request->post());
            var_dump($form_model);
        }
        return $this->render('page', compact('form_model'));
    }

    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    // public function actionPage()
    // {
    //     $form_model = new TestForm();
    //     return $this->render('page', compact('form_model'));
    // }
}
