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
    /**
     * @param int $id
     * 
     * @return object|null
     */
    public function getExecutor(int $id): ?object
    {
        return Users::find()
            ->joinWith('profile', 'city')
            ->where(['users.id' => $id])
            ->one();
    }

    /**
     * @param int $id
     * @param string $tasksStatus
     * 
     * @return int
     */
    public function getExecutorTasksCount(int $id, string $tasksStatus): int
    {
        return Tasks::find()
            ->where(['executor_id' => $id, 'status' => $tasksStatus])
            ->count();
    }

    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function getExecutorSpecializations(int $id): ?array
    {
        return Specializations::find()
            ->joinWith('specialization')
            ->where(['specialization_user_id' => $id])
            ->all();
    }

    /**
     * @param array $specializations
     * 
     * @return array
     */
    public function getCurrentSpecializations(array $specializations): array
    {
        $currentSpecializations = [];
        foreach ($specializations as $specialization) {
            $currentSpecializations[] = $specialization['specialization_id'];
        }
        return  $currentSpecializations;
    }

    /**
     * @param int $id
     * 
     * @return array|null
     */
    public function getExecutorOpinions(int $id): ?array
    {
        return Opinions::find()
            ->joinWith('task', 'profile')
            ->where(['opinions.opinion_executor_id' => $id])
            ->all();
    }

    /**
     * @param int $id
     * 
     * @return int
     */
    public function getExecutorRatingPosition(int $id): int
    {
        $usersRatings = Users::find()
            ->where(['role' => 1])
            ->joinWith('profile')
            ->orderBy('average_rating ASC')
            ->asArray()
            ->all();

        return array_search($id, array_column($usersRatings, 'id')) + 1;
    }

    /**
     * @param string $email
     * 
     * @return User|null
     */
    public function findUserByEmail(string $email): ?User
    {
        return User::findOne(['email' => $email]);
    }

    /**
     * @param RegistrationForm $RegistrationModel
     * 
     * @return void
     */
    public function saveNewUserProfile(RegistrationForm $RegistrationModel)
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

    /**
     * @param array $attributes
     * 
     * @return User|null
     */
    public function saveNewVkProfile(array $attributes): ?User
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

    /**
     * @param object $userProfile
     * @param EditProfileForm $EditProfileFormModel
     * 
     * @return void
     */
    public function editUserProfile(object $userProfile, EditProfileForm $EditProfileFormModel)
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
            ->where(['specialization_user_id' => $userProfile->id])
            ->all();
        Specializations::deleteAll(['specialization_user_id' => $userProfile->id]);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $userProfile->save();
            $userProfile->profile->save();
            if (count($specializations) > 0) {
                foreach ($specializations as $specializationId) {
                    $userSpecializations = new Specializations();
                    $userSpecializations->specialization_user_id = $userProfile->id;
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

    /**
     * @param object $userProfile
     * @param SecurityForm $SecurityFormModel
     * 
     * @return void
     */
    public function updateSecuritySettings(object $userProfile, SecurityForm $SecurityFormModel)
    {
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($SecurityFormModel->new_password);
        $userProfile->password = $passwordHash;

        if ($userProfile->role === 1) {
            $userProfile->profile->private = $SecurityFormModel->private;
        } else {
            $userProfile->profile->private = 0;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($SecurityFormModel->current_password) {
                $userProfile->save();
            }
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
