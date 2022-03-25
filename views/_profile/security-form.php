<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['autocomplete' => 'off']
]); ?>

<h3 class="head-main head-regular">Безопасность</h3>

<?php
print($userProfile->role);
?>

<div class="form-group">
    <?php if ($userProfile->role === 1) : ?>
        <?php
        if ($userProfile->profile->private === 1) {
            $checked = 'checked';
        } else {
            $checked = Null;
        }
        ?>
        <?= $form->field($SecurityFormModel, 'private')->checkbox() ?>

    <?php endif; ?>
</div>

<div class="form-group">
    <?= $form->field($SecurityFormModel, 'current_password')->passwordInput(); ?>
    <?= $form->field($SecurityFormModel, 'new_password')->passwordInput(); ?>
    <?= $form->field($SecurityFormModel, 'new_password_repeat')->passwordInput(); ?>
</div>

<?= Html::submitInput('Сохранить', [
    'class' => 'button button--blue',
]); ?>

<?php ActiveForm::end(); ?>