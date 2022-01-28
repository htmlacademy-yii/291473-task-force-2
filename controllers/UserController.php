<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\services\UserService;

// use app\models\Users;
// use app\models\Profiles; // Перенес в сервис;
// use app\models\Tasks; // Перенес в сервис;
// use app\models\Specializations; // Перенес в сервис;
// use app\models\Opinions; // Перенес в сервис;

class UserController extends Controller
{
    public function actionView(int $id)
    {
        $userService = new UserService;

        // $profile = Profiles::find()
        // ->joinWith('user', 'city')
        // ->where(['profiles.id' => $id])
        // ->one();

        // $tasksFinishedCount = Tasks::find()
        // ->where(['executor_id' => $id, 'status' => 'finished'])
        // ->count();

        // $tasksFailedCount = Tasks::find()
        // ->where(['executor_id' => $id, 'status' => 'failed'])
        // ->count();

        // $tasksInProgressCount = Tasks::find()
        // ->where(['executor_id' => $id, 'status' => 'in_progress'])
        // ->count();

        // $specializations = Specializations::find()
        // ->joinWith('specialization')
        // ->where(['user_id' => $id])
        // ->all();

        // $opinions = Opinions::find()
        // ->joinWith('task', 'profile')
        // ->where(['opinions.executor_id' => $id])
        // ->all();

        // $usersRatings = Profiles::find()
        // ->where(['role' => 1])
        // ->orderBy('average_rating ASC')
        // ->asArray()
        // ->all();

        // $userRatingPosition = array_search($id, array_column($usersRatings, 'id')) + 1;

        $profile = $userService->getExecutor($id);
        $tasksFinishedCount = $userService->getExecutorTasksCount($id, 'finished');
        $tasksFailedCount = $userService->getExecutorTasksCount($id, 'failed');
        $tasksInProgressCount = $userService->getExecutorTasksCount($id, 'in_progress');
        $specializations = $userService->getExecutorSpecializations($id);
        $opinions = $userService->getExecutorOpinions($id);
        $userRatingPosition = $userService->getExecutorRatingPosition($id);

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
