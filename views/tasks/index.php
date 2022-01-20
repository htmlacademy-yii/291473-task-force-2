<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use TaskForce\utils\TaskTimeConverter;
?>

<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>

    <?php foreach ($tasks as $task) : ?>
        <div class="task-card">
            <div class="header-task">
                <a href="#" class="link link--block link--big"><?= Html::encode($task->name) ?></a>
                <p class="price price--task"><?= Html::encode($task->budget) ?> ₽</p>
            </div>
            <p class="info-text"><span class="current-time"><?= TaskTimeConverter::getTaskRelativeTime($task->dt_add) ?></span></p>
            <p class="task-text"><?= Html::encode($task->description) ?></p>
            <div class="footer-task">
                <p class="info-text town-text"><?= Html::encode($task->address) ?></p>
                <p class="info-text category-text"><?= Html::encode($task->category->name) ?></p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
    <?php endforeach; ?>


    <div class="pagination-wrapper">
        <ul class="pagination-list">
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">1</a>
            </li>
            <li class="pagination-item pagination-item--active">
                <a href="#" class="link link--page">2</a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">3</a>
            </li>
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
        </ul>
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
            ]) ?>

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
                                $html = "<input type=\"checkbox\" name=\"{$name}\" value=\"{$value}\"{$checked}>";

                                return "<label>{$html}{$label}</label>";
                            }
                        ]
                    ) ?>

                </div>
            </div>

            <?= Html::submitButton('Искать', ['class' => 'button button--blue']) ?>

            <?php ActiveForm::end() ?>

            <!-- <form>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div>
                        <input type="checkbox" id="сourier-services" checked>
                        <label class="control-label" for="сourier-services">Курьерские услуги</label>
                        <input id="cargo-transportation" type="checkbox">
                        <label class="control-label" for="cargo-transportation">Грузоперевозки</label>
                        <input id="translations" type="checkbox">
                        <label class="control-label" for="translations">Переводы</label>
                    </div>
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <input id="without-performer" type="checkbox" checked>
                    <label class="control-label" for="without-performer">Без исполнителя</label>
                </div>
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                    <label for="period-value"></label>
                    <select id="period-value">
                        <option>1 час</option>
                        <option>12 часов</option>
                        <option>24 часа</option>
                    </select>
                </div>
                <input type="button" class="button button--blue" value="Искать">
            </form> -->
        </div>
    </div>
</div>