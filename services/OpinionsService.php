<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Opinions;
use app\models\Profiles;
use app\models\FinishedTaskForm;

use TaskForce\utils\CustomHelpers;

class OpinionsService
{
    public function finishTask($user_id, $id, FinishedTaskForm $finishedTaskFormModel)
    {
        $task = Tasks::findOne(['id' => $id]);
        $task->status = 'finished';
        $opinions = new Opinions;
        $opinions->description = $finishedTaskFormModel->description;
        $opinions->rating = $finishedTaskFormModel->rating;
        $opinions->dt_add = CustomHelpers::getCurrentDate();
        $opinions->rate = $task->budget;
        $opinions->customer_id = $task->customer_id;
        $opinions->executor_id = $task->executor_id;
        $opinions->task_id = $id;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $opinions->save();
            $task->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
