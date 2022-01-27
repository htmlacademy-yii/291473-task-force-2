<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;
use app\models\Profiles;
use app\models\Tasks;
use app\models\Specializations;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionView(int $id)
    {
        $user = Users::find()
        ->joinWith('profile')
        ->where(['profile_id' => $id])
        ->one();

        $tasksFinishedCount = Tasks::find()
        ->where(['executor_id' => $id, 'status' => 'finished'])
        ->count();

        $tasksFailedCount = Tasks::find()
        ->where(['executor_id' => $id, 'status' => 'failed'])
        ->count();

        $tasksInProgressCount = Tasks::find()
        ->where(['executor_id' => $id, 'status' => 'new', 'status' => 'in_progress'])
        ->count();

        $specializations = Specializations::find()
        ->joinWith('specialization')
        ->where(['user_id' => $id])
        ->all();

        $usersRatings = Profiles::find()
        ->where(['role' => 1])
        ->orderBy('average_rating ASC')
        ->asArray()
        ->all();

        $userRatingPosition = array_search($id, array_column($usersRatings, 'id')) + 1;

        // Tasks
        // Opinions
        //Рейтинг пользователя считается по формуле: сумма всех оценок из отзывов / (кол-во отзывов + счетчик проваленных заданий).

        // $user = Profiles::find()
        //     ->joinWith('city', 'executorTasks')
        //     ->where(['profiles.id' => $id])
        //     ->one();


        // if (!$user) {
        //     throw new NotFoundHttpException('Доступ к профилю пользователя закрыт');
        // }

  

        // // $reviews = ReviewsSelector::getReviews($id, [TasksSelector::STATUS_DONE, TasksSelector::STATUS_REFUSED]);
        return $this->render('view', [
            'user' => $user,
            'specializations' => $specializations,
            'tasksFinishedCount' => $tasksFinishedCount,
            'tasksFailedCount' => $tasksFailedCount,
            'tasksInProgressCount' => $tasksInProgressCount,
            'userRatingPosition' => $userRatingPosition,
        ]);
    }
}
