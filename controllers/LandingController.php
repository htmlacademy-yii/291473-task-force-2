<?php

namespace app\controllers;

use app\models\LoginForm;
use yii\web\Controller;

class LandingController extends Controller
{
    public $layout = 'landing';

    public function actionIndex()
    {
        $loginForm = new LoginForm();

        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post()); // Проверим, что форма отправлена и загрузим в неё данные из ПОСТа;

            if ($loginForm->validate()) { // Запустим валидацию формы;
                $user = $loginForm->getUser(); // Если валидация прошла, то получим модель найденного пользователя из формы;
                \Yii::$app->user->login($user); //Вызываем логин пользователя средствами встроенного компонента User;

                return $this->goHome(); // Переадресуем на главную страницу;
            }
        }

        return $this->render('index', ['loginForm' => $loginForm]); //Показываем страницу с передачей в шаблон модели для формы входа;
    }
}



// class SignupController extends Controller
// {
//     public function actionIndex()
//     {
//         $this->layout = 'anon';
//         $user = new User();
//         if (Yii::$app->request->getIsPost()) {
//             $user->load(Yii::$app->request->post());
//             if (Yii::$app->request->isAjax) {
//                 return ActiveForm::validate($user);
//             }
//             if ($user->validate()) {
//                 // выполнить сохранение формы в БД
//             }
//         }
//         return $this->render('index', ['model' => $user]);
//     }
// }
