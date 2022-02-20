<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use TaskForce\utils\CustomHelpers;
use app\models\Users;

abstract class SecuredController extends Controller
{
    // Применяет правила авторизации к контроллерам;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    // // Редиректит на лендинг, если не авторизован;
    // public function beforeAction($action)
    // {
    //     if (CustomHelpers::checkAuthorization() === null) {
    //         $this->redirect('/landing');
    //         return false;
    //     }
    //     return true;
    // }

    // public function init()
    // {
    //     parent::init();
    //     if ($id = Yii::$app->user->getId()) {
    //         Yii::$app->params['user'] = Users::findOne($id);
    //     }
    // }
}
