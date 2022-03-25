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

<div class="form-group">
    <?= $form->field($SecurityFormModel, 'current_password')->passwordInput(); ?>
    <?= $form->field($SecurityFormModel, 'new_password')->passwordInput(); ?>
    <?= $form->field($SecurityFormModel, 'new_password_repeat')->passwordInput(); ?>
</div>

<?= Html::submitInput('Сохранить', [
    'class' => 'button button--blue',
]); ?>

<?php ActiveForm::end(); ?>