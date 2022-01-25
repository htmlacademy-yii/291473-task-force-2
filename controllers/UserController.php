<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Profiles;
use app\models\Users;

class UserController extends Controller
{
    public function actionView(int $id)
    {
        $user = Profiles::find()
        // ->joinWith('city', 'category')
        ->where(['profiles.id' => $id])
        ->one();
        

        if (!$user) {
            throw new NotFoundHttpException('Доступ к профилю пользователя закрыт');
        }

        // $reviews = ReviewsSelector::getReviews($id, [TasksSelector::STATUS_DONE, TasksSelector::STATUS_REFUSED]);
        return $this->render('view', [
            'user' => $user,
            // 'reviews' => $reviews,
        ]);
    }
}