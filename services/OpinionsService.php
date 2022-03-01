<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Opinions;
use app\models\Profiles;
use app\models\FinishedForm;

use TaskForce\utils\CustomHelpers;

class OpinionsService
{
    public function finishTask($id, FinishedForm $FinishedFormModel)
    {
        $task = Tasks::findOne(['id' => $id]);
        $opinions = new Opinions;
        $task->status = 'finished';
        $opinions->description = $FinishedFormModel->description;
        $opinions->rating = $FinishedFormModel->rating;
        $opinions->dt_add = CustomHelpers::getCurrentDate();
        $opinions->rate = $task->budget;
        $opinions->customer_id = $task->customer_id;
        $opinions->executor_id = $task->executor_id;
        $opinions->task_id = $id;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $task->save();
            $opinions->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
