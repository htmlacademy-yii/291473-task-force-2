<?php

namespace app\controllers;

use Yii;
use app\models\TasksSearchForm;
use app\services\TasksFilterService;
use yii\web\NotFoundHttpException;
use app\services\TasksService;
use app\services\RepliesService;
use app\services\CategoriesService;
use app\models\Tasks;
use app\models\Categories;
use app\models\AddTaskForm;
use app\models\Replies;
use app\models\RefuseForm;
use app\models\FinishedTaskForm;
use app\services\OpinionsService;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['add'],
            'matchCallback' => function ($rule, $action) {
                if (isset(\Yii::$app->user->identity->role)) {
                    return \Yii::$app->user->identity->role !== 0;
                }
            }
        ];

        array_unshift($rules['access']['rules'], $rule);
        return $rules;
    }

    public function actionIndex()
    {
        $model = new TasksSearchForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) {
                $tasks = (new TasksFilterService())->getFilteredTasks($model);
            }
        }

        !isset($tasks) && $tasks = Tasks::find()->all();
        $categories = Categories::find()->all();

        return $this->render('index', [
            'model' => $model,
            'tasks' => $tasks,
            'categories' => $categories,
            'period_values' => TasksSearchForm::PERIOD_VALUES
        ]);
    }

    public function actionView(int $id)
    {
        $userId = Yii::$app->user->getId();
        $tasksService = new TasksService;
        $task = $tasksService->getTask($id);
        $replies = $tasksService->getReplies($id);
        $task_files = $tasksService->getTaskFiles($id);

        if (!$task) {
            throw new NotFoundHttpException;
        }


        $repliesModel = new Replies();
        $refuseFormModel = new RefuseForm();
        $finishedTaskFormModel = new FinishedTaskForm();

        if (Yii::$app->request->isPost) {

            // Исполнитель. Оставить отклик на задание;
            if (Yii::$app->request->post('reply') === 'reply') {
                $repliesModel->load(Yii::$app->request->post());

                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($repliesModel);
                }

                if ($repliesModel->validate()) {
                    (new RepliesService())->createReply($userId, $id, $repliesModel);
                    return $this->refresh();
                }
            }

            // Исполнитель. Отменить задание;
            if (Yii::$app->request->post('refuse') === 'refuse') {
                $refuseFormModel->load(Yii::$app->request->post());
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($refuseFormModel);
                }

                if ($refuseFormModel->validate()) {
                    (new RepliesService())->RefuseTask($userId, $id, $refuseFormModel);
                    return $this->refresh();
                    // $userId - id пользователя
                    // $id - id задачи
                    // $refuseFormModel - данные из формы отказа от задачи
                }
            }

            // Заказчик. Завершить задание;
            if (Yii::$app->request->post('finished') === 'finished') {

                $finishedTaskFormModel->load(Yii::$app->request->post());
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    print('OK');

                    return ActiveForm::validate($finishedTaskFormModel);
                }

                if ($finishedTaskFormModel->validate()) {
                    (new OpinionsService())->finishTask($userId, $id, $finishedTaskFormModel);
                    // return $this->refresh();
                    // $userId - id пользователя
                    // $id - id задачи
                    // $refuseFormModel - данные из формы отказа от задачи
                }
            }
        }

        return $this->render('view', [
            'task' => $task,
            'replies' => $replies,
            'repliesModel' => $repliesModel,
            'refuseFormModel' => $refuseFormModel,
            'finishedTaskFormModel' => $finishedTaskFormModel,
            'task_files' => $task_files,
        ]);
    }

    public function actionAdd()
    {
        $addTaskFormModel = new AddTaskForm();
        $tasksService = new TasksService;

        if (Yii::$app->request->isPost) {
            $addTaskFormModel->load(Yii::$app->request->post());
            $addTaskFormModel->files = UploadedFile::getInstances($addTaskFormModel, 'files');

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($addTaskFormModel);
            }

            if ($addTaskFormModel->validate()) {
                $taskId = $tasksService->createTask($addTaskFormModel);
                $this->redirect(['tasks/view', 'id' => $taskId]);
            }
        }

        $categoriesModel = new CategoriesService();
        $categories = $categoriesModel->findAll();

        return $this->render('add', [
            'addTaskFormModel' => $addTaskFormModel,
            'categories' => $categories
        ]);
    }

    // Принять отклик исполнителя;
    public function actionAccept(int $id)
    {
        $RepliesService = new RepliesService;
        $reply = $RepliesService->AcceptReply($id);

        return $this->actionView($reply->task_id);
    }
}
