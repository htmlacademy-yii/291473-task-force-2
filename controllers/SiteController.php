<?php

namespace app\controllers;

use Yii;
use app\models\RegistrationForm;
use app\models\Cities;
use app\services\UserService;

class SiteController extends SecuredController //extends Controller
{
    public function actionRegistration()
    {
        $RegistrationModel = new RegistrationForm();

        $cities = Cities::find()
            ->select(['id', 'city'])
            ->indexBy('id')
            ->asArray()
            ->all();

        if (Yii::$app->request->getIsPost()) {
            $RegistrationModel->load(Yii::$app->request->post());

            if ($RegistrationModel->validate()) {
                (new UserService())->SaveNewUserProfile($RegistrationModel);
                return $this->goHome();
            }
        }

        return $this->render('registration', [
            'model' => $RegistrationModel,
            'cities' => $cities,
        ]);
    }
}
