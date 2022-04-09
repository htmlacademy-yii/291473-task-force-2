<?php

use yii\widgets\Menu;
use TaskForce\tasks\Task;
use yii\widgets\ListView;

$this->title = 'Мои задания';
?>

<div class="left-menu">
    <h3 class="head-main head-task">Мои задания</h3>
    <ul class="side-menu-list">

        <?php
        if (Yii::$app->user->identity->role === Task::ROLE_CUSTOMER) {
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