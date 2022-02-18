<?php

namespace app\controllers;

use Yii;
use app\models\TasksSearchForm;
use app\services\TasksFilterService;
use yii\web\NotFoundHttpException;
use app\services\TasksService;
use app\services\CategoriesService;
use app\models\Tasks;
use app\models\Categories;
use app\models\AddTaskForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use app\services\UserService;
use yii\filters\AccessControl;

class TasksController extends SecuredController
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                     'actions' => ['add'],
    //                     'matchCallback' => function ($rule, $action) {
    //                         return (new UserService())->isCustomer(Yii::$app->user->id);
    //                     }
    //                 ],
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                     'actions' => ['index', 'view']
    //                 ]
    //             ]
    //         ]
    //     ];
    // }

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['add'],
            'matchCallback' => function ($rule, $action) {
                return false; // Даже когда возвращаю false, страница остается доступна.
            }
        ];

        array_unshift($rules['access']['rules'], $rule);
        return $rules;
    }

    // Средиректит на задания, если не постановщик зайдет на страницу создания задания;
    // public function beforeAction($action)
    // {
    //     if ($action->id === 'add') {
    //         $user = CustomHelpers::checkAuthorization();
    //         if ($user->role === 1) {
    //             $this->redirect('/tasks');
    //         }
    //     }
    //     return parent::beforeAction($action);
    // }

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
        $tasksService = new TasksService;
        $task = $tasksService->getTask($id);
        $replies = $tasksService->getReplies($id);
        $task_files = $tasksService->getTaskFiles($id);

        if (!$task) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'task' => $task,
            'replies' => $replies,
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
}
