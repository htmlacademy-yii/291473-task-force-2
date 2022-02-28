<?php

namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\Replies;
use app\models\Profiles;

use TaskForce\utils\CustomHelpers;

class RepliesService
{

    public function createReply($user_id, $id, Replies $repliesModel)
    {
        $reply = new Replies;
        $reply->dt_add = CustomHelpers::getCurrentDate();
        $reply->rate = $repliesModel->rate;
        $reply->description = $repliesModel->description;
        $reply->executor_id = Yii::$app->user->id;
        $reply->task_id = $id;
        $reply->executor_id = $user_id;
        $reply->save();
    }

    public function AcceptReply($id)
    {
        $reply = Replies::findOne(['id' => $id]);
        $task = Tasks::findOne(['id' => $reply->task_id]);
        $reply->status = 1;
        $task->executor_id = $reply->executor_id;
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

    public function RefuseTask($user_id, $id, Replies $repliesModel)
    {
        $reply = Replies::findOne(['id' => $id]);
        $task = Tasks::findOne(['id' => $reply->task_id]);
        $executor = Profiles::findOne(['user_id' => $user_id]);

        print($reply);

        // $reply->description = $repliesModel->description;
        // $task->status = 'finished';
        // $executor->filed_tasks = $executor->filed_tasks++;

        // $transaction = Yii::$app->db->beginTransaction();
        // try {
        //     $reply->save();
        //     $task->save();
        //     $executor->save();
        //     $transaction->commit();
        // } catch (\Exception $e) {
        //     $transaction->rollBack();
        //     throw $e;
        // } catch (\Throwable $e) {
        //     $transaction->rollBack();
        // }
    }
}
