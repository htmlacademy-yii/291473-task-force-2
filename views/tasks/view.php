<?php

use yii\helpers\Html;
use TaskForce\utils\NounPluralConverter;
use TaskForce\utils\CustomHelpers;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;


$userId = Yii::$app->user->getId();

?>

<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?= Html::encode($task->name); ?></h3>
        <p class="price price--big"><?= Html::encode($task->budget); ?></p>
    </div>
    <p class="task-description"><?= Html::encode($task->description); ?></p>

    <!-- <a href="#" class="button button--blue">Откликнуться на задание</a> -->


    <!-- Исполнитель. Отклик на новое задание. -->
    <?php if (
        $task->status === 'new' // Задача должна быть в статусе "Новая" (не взятая в работу);
        && $task->customer_id !== $userId // Пользователь не может быть постановщиком задачи;
        && \Yii::$app->user->identity->role === 1 // Роль пользователя должна быть - исполнитель;
        && CustomHelpers::checkExecutor($replies, $userId) // Проверяю, что пользователь еще не откликнулся на задание;
    ) : ?>
        <?php Modal::begin([
            'title' => '<h2>Отправка отклика</h2>',
            'toggleButton' => [
                'label' => 'Откликнуться на задание',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
        <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
        <?= $form->field($repliesModel, 'description')->textarea(['autofocus' => true]) ?>
        <?= $form->field($repliesModel, 'rate')->input('number') ?>
        <div class="form-group">
            <!-- <button type="submit" class="modal-button">Отправить</button> -->
            <button type="submit" class="modal-button" form="modal-form" name="reply" value="reply">Отправить</button>
            <button type="button" class="modal-button" data-dismiss="modal">Отменить</button>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>
    <?php endif; ?>


    <!-- Исполнитель. Отказ от взятого в работу задания -->
    <?php if (
        $task->status === 'in_progress' // Задача должна быть в работе;
        && $task->executor_id === $userId // ID исполнителя из задачи должен быть равен ID авторизованного пользователя;
    ) : ?>
        <?php Modal::begin([
            'title' => '<h2>Подвердите отказ от задания</h2>',
            'toggleButton' => [
                'label' => 'Отказ от задания',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
        <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
        <?= $form->field($refuseFormModel, 'description')->textarea(['autofocus' => true]) ?>
        <div class="form-group">

            <button type="submit" class="modal-button" form="modal-form" name="refuse" value="refuse">Отказаться</button>
            <button type="button" class="modal-button" data-dismiss="modal">Вернуться</button>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>
    <?php endif; ?>

    <!-- Постановщик. Завершение задания -->
    <?php if (
        $task->status === 'in_progress' // Задача должна быть в работе;
        && $task->customer_id === $userId // ID исполнителя из задачи должен быть равен ID авторизованного пользователя;
    ) : ?>
        <?php Modal::begin([
            'title' => '<h2>Принять задание</h2>',
            'toggleButton' => [
                'label' => 'Завершить задание',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
        <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
        <?= $form->field($finishedTaskFormModel, 'description')->textarea(['autofocus' => true]) ?>
        <?= $form->field($finishedTaskFormModel, 'rating')->input('number', ['min' => '0', 'max' => '5']) ?>
        <div class="form-group">
            <button type="submit" class="modal-button" form="modal-form" name="finished" value="finished">Завершить</button>
            <button type="button" class="modal-button" data-dismiss="modal">Вернуться</button>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>
    <?php endif; ?>



    <div class="task-map">
        <img class="map" src="/img/map.png" width="725" height="346" alt="<?= Html::encode($task->address); ?>">
        <p class="map-address town"><?= Html::encode(isset($task->city->city)); ?></p>
        <p class="map-address"><?= Html::encode($task->address) ?></p>
    </div>


    <?php if (CustomHelpers::checkCustomerOrExecutor($replies, $task, $userId)) : ?>
        <h4 class="head-regular">Отклики на задание</h4>
    <?php endif; ?>

    <?php foreach ($replies as $reply) : ?>
        <?php if ($reply->executor_id === $userId || $task->customer_id === $userId) : ?>
            <div class="response-card">
                <img class="customer-photo" src="<?= (Html::encode($reply->executor->avatar_link)); ?>" width="146" height="156" alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <a href="#" class="link link--block link--big"></a>
                    <div class="response-wrapper">
                        <div class="stars-rating small">
                            <?= CustomHelpers::getRatingStars(Html::encode($reply->executor->average_rating)); ?>
                        </div>
                        <p class="reviews"><?= (count($reply->opinion)); ?> <?= NounPluralConverter::getOpinionsTitle(count($reply->opinion)); ?></p>
                    </div>
                    <p class="response-message">
                        <?= Html::encode($reply->description); ?>
                    </p>

                </div>
                <div class="feedback-wrapper">
                    <p class="info-text"><span class="current-time"><?= NounPluralConverter::getTaskRelativeTime($reply->dt_add); ?></span></p>
                    <p class="price price--small"><?= Html::encode($reply->rate); ?> ₽</p>
                </div>
                <?php if ($task->customer_id === $userId && !isset($reply->status) && CustomHelpers::checkRepliesStatus($replies)) : ?>
                    <div class="button-popup">
                        <a href="<?= '/accept/' . $reply->id ?>" class="button button--blue button--small">Принять</a>
                        <a href="<?= '/reject/' . $reply->id ?>" class="button button--orange button--small">Отказать</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>



</div>

<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?= Html::encode($task->category->name); ?></dd>
            <dt>Дата публикации</dt>
            <dd><?= NounPluralConverter::getTaskRelativeTime($task->dt_add); ?></dd>
            <dt>Срок выполнения</dt>
            <dd><?= Html::encode(CustomHelpers::checkNullDate($task->deadline)); ?></dd>
            <dt>Статус</dt>
            <dd><?= CustomHelpers::getTaskStatusName(Html::encode($task->status)); ?></dd>
        </dl>
    </div>

    <?php if (count($task_files) > 0) : ?>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <?php foreach ($task_files as $task_file) : ?>
                    <li class="enumeration-item">
                        <a target="_blank" href="<?= '/uploads/' . $task_file->link ?>" class="link link--block link--clip"><?= $task_file->link ?></a>
                        <p class="file-size"><?= CustomHelpers::getFileSize($task_file->link) ?> Кб</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>