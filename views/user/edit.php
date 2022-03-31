<?php

use yii\widgets\Menu;

$this->title = 'Редактирование профиля';

?>

<div class="main-content main-content--left container">
    <div class="left-menu left-menu--edit">
        <h3 class="head-main head-task">Настройки</h3>
        <?php
        $menuItems = [
            ['label' => 'Мой профиль', 'url' => ['user/edit', 'page' => 'profile']],
            ['label' => 'Безопасность', 'url' => ['user/edit', 'page' => 'security']],
            ['label' => 'Уведомления', 'url' => ['/', 'page' => 'profile']],
        ];
        ?>

        <?= Menu::widget([
            'items' => $menuItems,
            'activeCssClass' => 'side-menu-item--active',
            'itemOptions' => ['class' => 'side-menu-item'],
            'labelTemplate' => '<a class="link link--nav">{label}</a>',
            'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
            'options' => ['class' => 'side-menu-list']
        ]); ?>
    </div>

    <div class="my-profile-form">
        <?php if (in_array($page, ['profile', 'security'])) : ?>
            <?php $model = "{$page}Form"; ?>
            <?= $this->render("//_profile/{$page}-form", [
                'userProfile' => $userProfile,
                'EditProfileFormModel' => $EditProfileFormModel,
                'categories' => $categories,
                'currentSpecializations' => $currentSpecializations,
                'SecurityFormModel' => $SecurityFormModel,
            ]) ?>
        <?php endif; ?>
    </div>
</div>