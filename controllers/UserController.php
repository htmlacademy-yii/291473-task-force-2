<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\services\UserService;
use app\models\EditProfileForm;
use app\services\CategoriesService;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class UserController extends SecuredController
{
    public function actionView(int $id)
    {
        $userService = new UserService;
        $user = $userService->getExecutor($id);
        $tasksFinishedCount = $userService->getExecutorTasksCount($id, 'finished');
        $tasksFailedCount = $userService->getExecutorTasksCount($id, 'failed');
        $tasksInProgressCount = $userService->getExecutorTasksCount($id, 'in_progress');
        $specializations = $userService->getExecutorSpecializations($id);
        $opinions = $userService->getExecutorOpinions($id);
        $userRatingPosition = $userService->getExecutorRatingPosition($id);

        if (!$user) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'user' => $user,
            'specializations' => $specializations,
            'tasksFinishedCount' => $tasksFinishedCount,
            'tasksFailedCount' => $tasksFailedCount,
            'tasksInProgressCount' => $tasksInProgressCount,
            'userRatingPosition' => $userRatingPosition,
            'opinions' => $opinions,
        ]);
    }

    public function actionEdit()
    {
        $EditProfileFormModel = new EditProfileForm();
        $categories = (new CategoriesService())->findAll();
        $userId = Yii::$app->user->getId();
        $userProfile = (new UserService())->getExecutor($userId);

        if (Yii::$app->request->isPost) {
            $EditProfileFormModel->load(Yii::$app->request->post());
            $EditProfileFormModel->avatar = UploadedFile::getInstance($EditProfileFormModel, 'avatar');

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($EditProfileFormModel);
            }

            // if ($EditProfileFormModel->validate()) {
            (new UserService())->EditUserProfile($userProfile, $EditProfileFormModel);
            // return $this->refresh();
            // }
        }

        return $this->render('edit', [
            'userProfile' => $userProfile,
            'EditProfileFormModel' => $EditProfileFormModel,
            'categories' => $categories,
            // 'user' => $user,
            // 'specializations' => $specializations,
            // 'tasksFinishedCount' => $tasksFinishedCount,
            // 'tasksFailedCount' => $tasksFailedCount,
            // 'tasksInProgressCount' => $tasksInProgressCount,
            // 'userRatingPosition' => $userRatingPosition,
            // 'opinions' => $opinions,
        ]);
    }
}
