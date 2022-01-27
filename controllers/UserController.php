<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;
use app\models\Profiles;
use app\models\Tasks;
use app\models\Specializations;
use app\models\Opinions;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionView(int $id)
    {

        $profile = Profiles::find()
        ->joinWith('user', 'city')
        ->where(['profiles.id' => $id])
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

        $opinions = Opinions::find()
        ->joinWith('task', 'profile')
        ->where(['opinions.executor_id' => $id])
        ->all();

        $usersRatings = Profiles::find()
        ->where(['role' => 1])
        ->orderBy('average_rating ASC')
        ->asArray()
        ->all();

        $userRatingPosition = array_search($id, array_column($usersRatings, 'id')) + 1;

        if (!$profile) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'profile' => $profile,
            'specializations' => $specializations,
            'tasksFinishedCount' => $tasksFinishedCount,
            'tasksFailedCount' => $tasksFailedCount,
            'tasksInProgressCount' => $tasksInProgressCount,
            'userRatingPosition' => $userRatingPosition,
            'opinions' => $opinions,
        ]);
    }
}
