<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use TaskForce\utils\NounPluralConverter;

$this->registerJsFile('/js/fileInputHandler.js');

$this->title = 'Создать задание';
$this->params['mainClass'] = ' main-content--center';
?>

<div class="add-task-form regular-form">
    <?php $form = ActiveForm::begin([
        'id' => 'add-task',
        // 'options' => ['autocomplete' => 'off'],
    ]); ?>

    <h3 class="head-main">Публикация нового задания</h3>

    <?= $form->field($addTaskFormModel, 'name')->textInput() ?>
    <?= $form->field($addTaskFormModel, 'description')->textarea() ?>
    <?= $form->field($addTaskFormModel, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name')) ?>
    <?= $form->field($addTaskFormModel, 'location')->textInput() ?>

    <div class="half-wrapper">
        <?= $form->field($addTaskFormModel, 'budget')->input('number') ?>
        <?= $form->field($addTaskFormModel, 'deadline', ['enableAjaxValidation' => true])->input('date', ['placeholder' => 'гггг-мм-дд']) ?>
    </div>

    <p class="form-label">Файлы</p>
    <div class="new-file">
        <?= $form
            ->field($addTaskFormModel, 'files[]', ['template' => "{input}{label}", 'labelOptions' => ['class' => 'add-file']])
            ->fileInput(['style' => 'display: none;', 'multiple' => true]) ?>
    </div>

    <!-- <?= $form->field($addTaskFormModel, 'latitude', ['template' => '{input}'])->hiddenInput() ?>
    <?= $form->field($addTaskFormModel, 'longitude', ['template' => '{input}'])->hiddenInput() ?>
    <?= $form->field($addTaskFormModel, 'city_name', ['template' => '{input}'])->hiddenInput() ?> -->

    <?= Html::submitInput('Опубликовать', ['class' => 'button button--blue']) ?>

    <?php ActiveForm::end(); ?>

    <!-- <form>
        <h3 class="head-main head-main">Публикация нового задания</h3>
        <div class="form-group">
            <label class="control-label" for="essence-work">Опишите суть работы</label>
            <input id="essence-work" type="text">
        </div>
        <div class="form-group">
            <label class="control-label" for="username">Подробности задания</label>
            <textarea id="username"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label" for="town-user">Категория</label>
            <select id="town-user">
                <option>Курьерские услуги</option>
                <option>Грузоперевозки</option>
                <option>Клининг</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label" for="location">Локация</label>
            <input id="location" type="text">
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <label class="control-label" for="budget">Бюджет</label>
                <input id="budget" type="number">
            </div>
            <div class="form-group">
                <label class="control-label" for="period-execution">Срок исполнения</label>
                <input id="period-execution" type="date">
            </div>
        </div>
        <p class="form-label">Файлы</p>
        <div class="new-file">
            <p class="add-file">Добавить новый файл</p>
        </div>
        <input type="button" class="button button--blue" value="Опубликовать">
    </form> -->
</div>