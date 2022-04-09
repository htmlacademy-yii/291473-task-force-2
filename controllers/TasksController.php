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
use app\models\FinishedForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use TaskForce\tasks\Task;
use yii\data\ActiveDataProvider;
use app\models\ResponseForm;

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
                    return \Yii::$app->user->identity->role !== Task::ROLE_CUSTOMER;
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
                $query = (new TasksFilterService())->getFilteredTasks($model);
            }
        }

        !isset($query) && $query = Tasks::find();
        $categories = Categories::find()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'dt_add' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'period_values' => TasksSearchForm::PERIOD_VALUES
        ]);
    }

    public function actionView(int $id)
    {
        $userId = Yii::$app->user->getId();
        $tasksService = new TasksService;
        $task = $tasksService->getTask($id);

        if (!$task) {
            throw new NotFoundHttpException;
        }

        $Actions = new Task($task->customer_id, $task->executor_id, $userId, $task->status);
        $taskAction = $Actions->get_user_actions($task->status);
        $replies = $tasksService->getReplies($id);
        $task_files = $tasksService->getTaskFiles($id);

        $responseFormModel = new ResponseForm();
        $refuseFormModel = new RefuseForm();
        $finishedFormModel = new FinishedForm();

        if (Yii::$app->request->isPost) {
            (new TasksService())->createTaskAction($userId, $id, 'response', $responseFormModel);
            (new TasksService())->createTaskAction($userId, $id, 'refuse', $refuseFormModel);
            (new TasksService())->createTaskAction($userId, $id, 'finished', $finishedFormModel);
            return $this->refresh();
        }

        return $this->render('view', [
            'task' => $task,
            'replies' => $replies,
            'task_files' => $task_files,
            'responseFormModel' => $responseFormModel,
            'refuseFormModel' => $refuseFormModel,
            'finishedFormModel' => $finishedFormModel,
            'taskAction' => $taskAction,
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

    public function actionAccept(int $id)
    {
        $RepliesService = new RepliesService;
        $reply = $RepliesService->AcceptReply($id);
        return $this->redirect(['tasks/view/' . $reply->reply_task_id]);
    }

    public function actionReject(int $id)
    {
        $reply = Replies::findOne(['id' => $id]);
        $reply->status = 0;
        $reply->save();
        return $this->redirect(['tasks/view/' . $reply->reply_task_id]);
    }

    public function actionCancel(int $id)
    {
        $tasksModel = Tasks::findOne(['id' => $id]);
        if (Yii::$app->user->getId() !== $tasksModel->customer_id) {
            throw new ForbiddenHttpException('У Вас нет прав отменить это задание!');
        }

        $tasksModel->status = 'canceled';
        $tasksModel->update();
        return $this->redirect(['tasks/view/' . $id]);
    }
}
