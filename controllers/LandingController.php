<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\LoginForm;
use yii\web\Controller;
use yii\web\Response;
use TaskForce\utils\CustomHelpers;
use yii\filters\AccessControl;

class LandingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'matchCallback' => function ($rule, $action) {
                            return CustomHelpers::checkAuthorization() === null;
                        }
                    ]
                ]
            ]
        ];
    }

    public $layout = 'landing';

    public function actionIndex()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                $this->redirect('/tasks/index');
            }
        }
        return $this->render('index', ['loginForm' => $loginForm]);
    }

    public function beforeAction($action)
    {
        if (CustomHelpers::checkAuthorization() !== null) {
            $this->redirect('/tasks/index');
            return false;
        }
        return true;
    }
}
