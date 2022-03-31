<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "opinions".
 *
 * @property string $dt_add
 * @property int $rate
 * @property string|null $description
 * @property int $customer_id
 * @property int $executor_id
 * @property int $task_id
 * @property int $rating
 * @property int $id
 */

class FinishedForm extends Model
{

    public $description;
    public $rating;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'rating'], 'required'],
            [['rating'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'description' => 'Опишите, как справился исполнитель:',
            'rating' => 'Оцените работу от 1 до 5',
        ];
    }
}
