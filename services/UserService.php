<?php

namespace app\services;

use Yii;
use app\models\Profiles;
use app\models\Tasks;
use app\models\Specializations;
use app\models\Opinions;
use app\models\Users;
use app\models\User;
use app\models\Cities;
use app\models\RegistrationForm;
use app\models\EditProfileForm;
use app\models\SecurityForm;
use TaskForce\utils\CustomHelpers;

class UserService
{
    public function getExecutor($id)
    {
        return Users::find()
            ->joinWith('profile', 'city')
            ->where(['users.id' => $id])
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

    public function getCurrentSpecializations($specializations)
    {
        $currentSpecializations = [];
        foreach ($specializations as $specialization) {
            $currentSpecializations[] = $specialization['specialization_id'];
        }
        return  $currentSpecializations;
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
        $usersRatings = Users::find()
            ->where(['role' => 1])
            ->joinWith('profile')
            ->orderBy('average_rating ASC')
            ->asArray()
            ->all();

        return array_search($id, array_column($usersRatings, 'id')) + 1;
    }

    public function findUserByEmail(string $email): ?User
    {
        return User::findOne(['email' => $email]);
    }

    public function SaveNewUserProfile(RegistrationForm $RegistrationModel): void
    {
        $user = new Users();
        $profile = new Profiles();

        $user->city_id = $RegistrationModel->city_id;
        $user->role = $RegistrationModel->role;
        $user->name = $RegistrationModel->name;
        $user->email = $RegistrationModel->email;
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($RegistrationModel->password);
        $user->password = $passwordHash;
        $user->dt_add = CustomHelpers::getCurrentDate(); //date("Y.m.d H:i:s");

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->save();
            $profile->user_id = $user->id;
            $profile->avatar_link = '/img/avatars/' . random_int(1, 5) . '.png';
            $profile->average_rating = 0;
            $profile->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }

    public function SaveNewVkProfile($attributes, $source)
    {
        $user = new User();
        $profile = new Profiles();

        if (isset($attributes['city']['title'])) {
            $cityVk = $attributes['city']['title'];

            $city = Cities::findOne(['city' => $cityVk]);
            if (isset($city)) {
                $user->city_id = $city['id'];
            }
        }

        $user->role = 1;
        $user->name = "{$attributes['first_name']} {$attributes['last_name']}";
        $user->email = $attributes['email'];
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash(mt_rand(8, 10));
        $user->password = $passwordHash;
        $user->dt_add = CustomHelpers::getCurrentDate(); //date("Y.m.d H:i:s");

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->save();
            $profile->user_id = $user->id;
            $profile->avatar_link = '/img/avatars/' . random_int(1, 5) . '.png';
            $profile->average_rating = 0;
            $profile->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }

        return $user;
    }

    public function EditUserProfile($userProfile, EditProfileForm $EditProfileFormModel)
    {
        $avatar = $EditProfileFormModel->avatar;
        if (isset($avatar)) {
            $file_path = uniqid('file_') . '.' . $avatar->extension;
            $avatar->saveAs(Yii::getAlias('@webroot') . '/img/avatars/' . $file_path);

            $userProfile->profile->avatar_link = '/img/avatars/' . $file_path;
        }

        $userProfile->name = $EditProfileFormModel->name;
        $userProfile->email = $EditProfileFormModel->email;
        $userProfile->profile->bd = $EditProfileFormModel->bd;
        $userProfile->profile->phone = $EditProfileFormModel->phone;
        $userProfile->profile->messanger = $EditProfileFormModel->messanger;
        $userProfile->profile->about = $EditProfileFormModel->about;

        $specializations = $EditProfileFormModel->categories;
        $userSpecializations = Specializations::find()
            ->where(['user_id' => $userProfile->id])
            ->all();
        Specializations::deleteAll(['user_id' => $userProfile->id]);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $userProfile->save();
            $userProfile->profile->save();
            if (count($specializations) > 0) {
                foreach ($specializations as $specializationId) {
                    $userSpecializations = new Specializations();
                    $userSpecializations->user_id = $userProfile->id;
                    $userSpecializations->specialization_id = $specializationId;
                    $userSpecializations->save();
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }

    public function UpdateSecuritySettings($userProfile, SecurityForm $SecurityFormModel)
    {
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($SecurityFormModel->new_password);
        $userProfile->password = $passwordHash;

        $userProfile->profile->private = $SecurityFormModel->private;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // $userProfile->save();
            $userProfile->profile->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
