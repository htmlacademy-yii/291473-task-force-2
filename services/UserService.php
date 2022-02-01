<?php

namespace app\services;

use Yii;
use app\models\Profiles;
use app\models\Tasks;
use app\models\Specializations;
use app\models\Opinions;

use app\models\Users;
use app\models\Cities;
use app\models\RegistrationForm;


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

    // Сохранение нового пользователя;
    public function SaveNewUserProfile(RegistrationForm $model): void
    {
        // print_r($model);

        // При сохранении нового пользователя:
        // 1. Создать запись Profiles 
        // 2. Создать запись Users - с pfofile_id, как id у записи в Profiles

        // Сохраняю имя -- модель Users
        // Сохраняю email -- модель Users
        // Сохраняю город -- модель Profiles
        // Сохраняю пароль -- модуль Users
        // Сохраняю роль - Модель Profiles

    }
}
