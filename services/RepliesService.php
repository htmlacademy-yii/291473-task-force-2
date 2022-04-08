<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Replies;
use app\models\ResponseForm;
use app\models\Profiles;
use app\models\RefuseForm;

use TaskForce\utils\CustomHelpers;

class RepliesService
{

    /**
     * @param int $user_id
     * @param int $id
     * @param ResponseForm $responseFormModel
     * 
     * @return void
     */
    public function createReply(int $user_id, int $id, ResponseForm $responseFormModel)
    {
        $reply = new Replies;
        $reply->dt_add = CustomHelpers::getCurrentDate();
        $reply->rate = $responseFormModel->rate;
        $reply->description = $responseFormModel->description;
        $reply->reply_task_id = $id;
        $reply->reply_executor_id = $user_id;
        $reply->save();
    }

    /**
     * @param int $id
     * 
     * @return object|null
     */
    public function AcceptReply(int $id): ?object
    {
        $reply = Replies::findOne(['id' => $id]);
        $task = Tasks::findOne(['id' => $reply->reply_task_id]);
        $reply->status = 1;
        $task->executor_id = $reply->reply_executor_id;
        $task->budget = $reply->rate;
        $task->status = 'in_progress';

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $reply->save();
            $task->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }

        return $reply;
    }

    /**
     * @param int $user_id
     * @param int $id
     * @param RefuseForm $refuseFormModel
     * 
     * @return void
     */
    public function RefuseTask(int $user_id, int $id, RefuseForm $refuseFormModel)
    {
        $reply = Replies::findOne(['task_id' => $id, 'executor_id' => $user_id]);
        $task = Tasks::findOne(['id' => $id]);
        $profile = Profiles::findOne(['user_id' => $user_id]);
        $reply->description = $refuseFormModel->description;
        $reply->dt_add = CustomHelpers::getCurrentDate();
        $task->status = 'failed';
        $profile->filed_tasks = $profile->filed_tasks + 1;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $reply->save();
            $task->save();
            $profile->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
