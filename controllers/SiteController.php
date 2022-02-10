<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use app\models\RegistrationForm;
use app\models\Cities;
use app\services\UserService;
use yii\web\Controller;
use TaskForce\utils\CustomHelpers;

class SiteController extends Controller //SecuredController
{
    // // Применяет правила авторизации к контроллерам;
    // public function behaviors()
    // {
    //     return [
    //         // 'verbs' => [
    //         //     'class' => VerbFilter::className(),
    //         //     'actions' => [
    //         //         'logout' => ['get'],
    //         //         'registration' => ['post', 'get'],
    //         //         'login' => ['post'],
    //         //     ],
    //         // ],
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['?']
    //                 ],
    //                 [
    //                     'allow' => false,
    //                     'roles' => ['@'],
    //                     'denyCallback' => function ($rule, $action) {
    //                         throw new HttpException(401, "Вы уже авторизованы!");
    //                     }
    //                 ]
    //             ]
    //         ]
    //     ];
    // }

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

        if (CustomHelpers::checkAuthorization() !== null) {
            return $this->goHome();
            // $this->redirect('/taskforce/web/landing'); // /landing
            // return false;
        }

        return $this->render('registration', [
            'model' => $RegistrationModel,
            'cities' => $cities,
        ]);
    }

    // Разлогинивает пользователя;
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
