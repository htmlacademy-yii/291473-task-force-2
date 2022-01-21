<?php

namespace TaskForce\utils;

use app\models\Tasks;
use app\models\TasksSearchForm;
use yii\db\Expression;

class TasksFilter
{
    public function getFilteredTasks(TasksSearchForm $model): array
    {
        $query = Tasks::find()
            ->joinWith('category')
            ->where(['status' => 1])
            ->orderBy('dt_add DESC');

        if ($model->categories) {
            $query->andWhere(['in', 'category_id', $model->categories]);
        }

        if ($model->without_executor) {
            $query->andWhere(['executor_id' => null]);
        }

        settype($model->period, 'integer');
        if ($model->period > 0) {
            $exp = new Expression("DATE_SUB(NOW(), INTERVAL {$model->period} HOUR)");
            $query->andWhere(['>', 'dt_add', $exp]);
        }

        return $query->all();
    }
}
