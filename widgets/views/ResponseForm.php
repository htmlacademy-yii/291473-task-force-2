<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="modal modal-hide form-modal" id="respond-form">
    <?= Html::tag('h2', 'Отклик на задание') ?>

    <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>

    <?= $form->field($formModel, 'description')->textarea(['autofocus' => true]) ?>
    <?= $form->field($formModel, 'rate')->input('number') ?>

    <div class="form-group">
        <button type="submit" class="modal-button" form="modal-form" name="response" value="response">Отправить</button>
        <button type="button" class="modal-button modal-close" data-dismiss="modal">Отменить</button>
    </div>

    <?php ActiveForm::end(); ?>

</section>