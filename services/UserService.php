<?php

namespace app\services;

use app\models\Profiles;
use app\models\Tasks;
use app\models\Specializations;
use app\models\Opinions;

class UserService
{

    public function getExecutor($id)
    {
        return Profiles::find()
            ->joinWith('user', 'city')
            ->where(['profiles.id' => $id])
            ->one();
    }

    public function getExecutorTasksCount($id, $tasksStatus)
    {
        return Tasks::find()
            ->where(['executor_id' => $id, 'status' => $tasksStatus])
            ->count();
    }

    public function getExecutorSpecializations($id)
    {
        return Specializations::find()
            ->joinWith('specialization')
            ->where(['user_id' => $id])
            ->all();
    }

    public function getExecutorOpinions($id)
    {
        return Opinions::find()
            ->joinWith('task', 'profile')
            ->where(['opinions.executor_id' => $id])
            ->all();
    }

    public function getExecutorRatingPosition($id)
    {
        $usersRatings = Profiles::find()
            ->where(['role' => 1])
            ->orderBy('average_rating ASC')
            ->asArray()
            ->all();

        return array_search($id, array_column($usersRatings, 'id')) + 1;
    }
}
