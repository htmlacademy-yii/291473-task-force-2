<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

$this->title = 'Новые задания';
?>

<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>

    <div class="pagination-wrapper">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_task',
            'pager' => [
                'prevPageLabel' => '',
                'nextPageLabel' => '',
                'pageCssClass' => 'pagination-item',
                'prevPageCssClass' => 'pagination-item mark',
                'nextPageCssClass' => 'pagination-item mark',
                'activePageCssClass' => 'pagination-item--active',
                'options' => ['class' => 'pagination-list'],
                'linkOptions' => ['class' => 'link link--page'],
                'options' => [
                    'class' => 'pagination-list',
                ],
            ],
        ]) ?>
    </div>

</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">

            <?php $form = ActiveForm::begin([
                'id' => 'tasks-form',
                'fieldConfig' => [
                    'template' => "{input}"
                ]
            ]); ?>

            <h4 class="head-card">Категории</h4>
            <div class="form-group">
                <div>
                    <?= $form->field($model, 'categories[]')->checkboxList(
                        ArrayHelper::map($categories, 'id', 'name'),
                        [
                            'separator' => '<br>',
                            'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                                settype($model->categories, 'array');
                                $checked = in_array($value, $model->categories) ? ' checked' : '';
                                $input = "<input type=\"checkbox\" name=\"{$name}\" id=\"{$value}\" value=\"{$value}\"{$checked}>";
                                $label = "<label class=\"control-label\" for=\"{$value}\">{$label}</label>";
                                return "{$input}{$label}";
                            }
                        ]
                    ); ?>
                </div>
            </div>

            <h4 class="head-card">Дополнительно</h4>
            <?= $form
                ->field($model, 'without_executor', ['template' => "{input}\n{label}"])
                ->checkbox(['id' => 'without-performer'], false); ?>

            <h4 class="head-card">Период</h4>
            <?= $form->field($model, 'period')->dropDownList($period_values, ['id' => 'period-value']); ?>
            <?= Html::submitButton('Искать', ['class' => 'button button--blue']); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>