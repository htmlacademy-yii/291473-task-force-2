<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\services\UserService;
use app\models\EditProfileForm;
use app\models\SecurityForm;
use app\services\CategoriesService;
use app\services\TasksService;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class UserController extends SecuredController
{
    public function actionView(int $id)
    {
        $userService = new UserService;
        $tasksService = new TasksService;
        $user = $userService->getExecutor($id);
        $tasksFinishedCount = $userService->getExecutorTasksCount($id, 'finished');
        $tasksFailedCount = $userService->getExecutorTasksCount($id, 'failed');
        $tasksInProgressCount = $userService->getExecutorTasksCount($id, 'in_progress');
        $specializations = $userService->getExecutorSpecializations($id);
        $opinions = $userService->getExecutorOpinions($id);
        $userRatingPosition = $userService->getExecutorRatingPosition($id);
        $allExecutorTasks = $tasksService->getTasksByExecutor($id);

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
            'allExecutorTasks' => $allExecutorTasks,
        ]);
    }

    public function actionEdit()
    {
        $page = Yii::$app->request->get('page');
        $EditProfileFormModel = new EditProfileForm();
        $SecurityFormModel = new SecurityForm();
        $categories = (new CategoriesService())->findAll();
        $userId = Yii::$app->user->getId();
        $userProfile = (new UserService())->getExecutor($userId);
        $specializations = (new UserService())->getExecutorSpecializations($userId);
        $currentSpecializations = (new UserService())->getCurrentSpecializations($specializations);

        if (Yii::$app->request->isPost && $page === 'profile') {
            $EditProfileFormModel->load(Yii::$app->request->post());
            $EditProfileFormModel->avatar = UploadedFile::getInstance($EditProfileFormModel, 'avatar');

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($EditProfileFormModel);
            }

            if ($EditProfileFormModel->validate()) {
                (new UserService())->EditUserProfile($userProfile, $EditProfileFormModel);
                return $this->refresh();
            }
        }

        if (Yii::$app->request->isPost && $page === 'security') {
            $SecurityFormModel->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($SecurityFormModel);
            }

            if ($SecurityFormModel->validate()) {
                (new UserService())->UpdateSecuritySettings($userProfile, $SecurityFormModel);
                return $this->redirect('/user/view/' . $userId);
            }
        }

        return $this->render('edit', [
            'page' => $page,
            'userProfile' => $userProfile,
            'EditProfileFormModel' => $EditProfileFormModel,
            'SecurityFormModel' => $SecurityFormModel,
            'categories' => $categories,
            'currentSpecializations' => $currentSpecializations,
        ]);
    }
}
