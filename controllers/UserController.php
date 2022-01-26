<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Profiles;
use app\models\Users;
use app\models\Specializations;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionView(int $id)
    {
        $user = Profiles::find()
            // ->joinWith('city', 'category')
            ->joinWith('city', 'executorTasks')
            ->where(['profiles.id' => $id])
            ->one();


        if (!$user) {
            throw new NotFoundHttpException('Доступ к профилю пользователя закрыт');
        }

        $specializations = Specializations::find()
            ->joinWith('specialization', 'user')
            ->where(['specializations.user_id' => $id])
            ->all();

        // $reviews = ReviewsSelector::getReviews($id, [TasksSelector::STATUS_DONE, TasksSelector::STATUS_REFUSED]);
        return $this->render('view', [
            'user' => $user,
            'specializations' => $specializations,
        ]);
    }
}
