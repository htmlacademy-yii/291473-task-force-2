<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\RegistrationForm;
use app\models\Cities;
use app\services\UserService;

class SiteController extends Controller
{


    public function actionRegistration()
    {

        $model = new RegistrationForm();

        $cities = Cities::find()
            ->select(['id', 'city'])
            ->indexBy('id')
            ->asArray()
            ->all();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) {
                (new UserService())->SaveNewUserProfile($model);
                $this->redirect('/tasks');
            }
        }

        return $this->render('registration', [
            'model' => $model,
            'cities' => $cities,
        ]);
    }
}
