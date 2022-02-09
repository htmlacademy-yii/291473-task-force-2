<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use TaskForce\utils\CustomHelpers;
use app\models\User;


abstract class SecuredController extends Controller
{
    // Применяет правила авторизации к контроллерам;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            throw new HttpException(401, "Вы не авторизованы!");
                        }
                    ]
                ]
            ]
        ];
    }

    // Редиректит на лендинг, если не авторизован;
    public function beforeAction($action)
    {
        if (CustomHelpers::checkAuthorization() === null) {
            $this->redirect('/landing');
            return false;
        }
        return true;
    }

    // Разлогинивает пользователя;
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    // Данные пользователя;
    public function actionProfile()
    {
        if ($id = \Yii::$app->user->getId()) {
            $user = User::findOne($id);

            print($user->email);
        }
    }
}
