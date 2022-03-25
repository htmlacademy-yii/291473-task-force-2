<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="main-content main-content--left container">
    <div class=" left-menu left-menu--edit">
        <h3 class="head-main head-task">Настройки</h3>
        <ul class="side-menu-list">
            <li class="side-menu-item side-menu-item--active">
                <a class="link link--nav">Мой профиль</a>
            </li>
            <li class="side-menu-item">
                <a href="#" class="link link--nav">Безопасность</a>
            </li>
            <li class="side-menu-item">
                <a href="#" class="link link--nav">Уведомления</a>
            </li>
        </ul>
    </div>
    <div class="my-profile-form">
        <?php $form = ActiveForm::begin([
            'id' => 'registration-form',
            'options' => ['autocomplete' => 'off']
        ]); ?>

        <h3 class="head-main head-regular">Безопасность</h3>

        <div class="form-group">
            <?= $form->field($EditProfileFormModel, 'current_password')->passwordInput(); ?>

        </div>


        <?= Html::submitInput('Сохранить', [
            'class' => 'button button--blue',
        ]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>