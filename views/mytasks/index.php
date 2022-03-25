<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
use yii\widgets\Menu;
use yii\widgets\LinkPager;

print(Yii::$app->user->identity->role);
?>

<div class="left-menu">
    <h3 class="head-main head-task">Мои задания</h3>
    <ul class="side-menu-list">

        <?php
        if (Yii::$app->user->identity->role === 0) {
            $myItems = [
                ['label' => 'Новые', 'url' => ['/mytasks/index', 'tasks_filter' => 'new'],],
                ['label' => 'В процессе', 'url' => ['/mytasks/index', 'tasks_filter' => 'in_progress']],
                ['label' => 'Закрытые', 'url' => ['/mytasks/index', 'tasks_filter' => 'closed']],
            ];
        } else {
            $myItems = [
                ['label' => 'В процессе', 'url' => ['/mytasks/index', 'tasks_filter' => 'in_progress']],
                ['label' => 'Просрочено', 'url' => ['/mytasks/index', 'tasks_filter' => 'overdue'],],
                ['label' => 'Закрытые', 'url' => ['/mytasks/index', 'tasks_filter' => 'closed']],
            ];
        }
        ?>

        <?= Menu::widget([
            'items' => $myItems,
            'activeCssClass' => 'side-menu-item--active',
            'itemOptions' => ['class' => 'side-menu-item'],
            'labelTemplate' => '<a class="link link--nav">{label}</a>',
            'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
            'options' => ['class' => 'side-menu-list']
        ]); ?>
    </ul>
</div>
<div class="left-column left-column--task">
    <?php if ($tasks_filter === 'new') : ?>
        <h3 class="head-main head-regular">Новые задания</h3>
    <?php elseif ($tasks_filter === 'in_progress') : ?>
        <h3 class="head-main head-regular">В процессе</h3>
    <?php elseif ($tasks_filter === 'closed') : ?>
        <h3 class="head-main head-regular">Закрытые</h3>
    <?php elseif ($tasks_filter === 'failed') : ?>
        <h3 class="head-main head-regular">Просроченные задания</h3>
    <?php else : ?>
        <h3 class="head-main head-regular">Все мои задания</h3>
    <?php endif; ?>

    <?php if (count($myTasks) > 0) : ?>
        <?php foreach ($myTasks as $task) : ?>
            <div class="task-card">
                <div class="header-task">
                    <a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link link--block link--big"><?= Html::encode($task->name); ?></a>
                    <p class="price price--task"><?= Html::encode($task->budget); ?> <?= Html::encode(isset($task->budget)) ? '₽' : ''; ?> </p>
                </div>
                <p class="info-text"><span class="current-time"><?= NounPluralConverter::getTaskRelativeTime($task->dt_add); ?></span></p>
                <p class="task-text"><?= Html::encode($task->description); ?></p>
                <div class="footer-task">
                    <p class="info-text town-text"><?= Html::encode($task->address); ?></p>
                    <p class="info-text category-text"><?= Html::encode($task->category->name); ?></p>
                    <a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Задания в данной категории отсутствуют.</p>
    <?php endif; ?>

    <div class="pagination-wrapper">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'options' => [
                'tag' => 'ul',
                'class' => 'pagination-list',
            ],
            'linkContainerOptions' => ['class' => 'pagination-item'],
            'linkOptions' => ['class' => 'link link--page'],
            'activePageCssClass' => 'pagination-item--active',
            'prevPageCssClass' => 'pagination-item mark',
            'nextPageCssClass' => 'pagination-item mark',
            'prevPageLabel' => '',
            'nextPageLabel' => '',
        ]); ?>
    </div>

</div>