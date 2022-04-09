<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>

<div class="task-card">
    <div class="header-task">
        <a href="<?= Url::to(['tasks/view', 'id' => $model->id]); ?>" class="link link--block link--big"><?= Html::encode($model->name); ?></a>
        <p class="price price--task"><?= Html::encode($model->budget); ?> <?= Html::encode(isset($model->budget)) ? '₽' : ''; ?> </p>
    </div>
    <p class="info-text"><span class="current-time"><?= NounPluralConverter::getTaskRelativeTime($model->dt_add); ?></span></p>
    <p class="task-text"><?= Html::encode($model->description); ?></p>
    <div class="footer-task">
        <p class="info-text town-text"><?= Html::encode($model->address); ?></p>
        <p class="info-text category-text"><?= Html::encode($model->category->name); ?></p>
        <a href="<?= Url::to(['tasks/view', 'id' => $model->id]); ?>" class="button button--black">Смотреть Задание</a>
    </div>
</div>