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

        <h3 class="head-main head-regular">Мой профиль</h3>
        <div class="photo-editing">
            <div>
                <p class="form-label">Аватар</p>
                <img class="avatar-preview" src="<?= Url::to($userProfile->profile->avatar_link); ?>" width="83" height="83">
            </div>

            <?= $form
                ->field($EditProfileFormModel, 'avatar', ['template' => "{input}{label}", 'labelOptions' => ['class' => 'button button--black']])
                ->fileInput(['style' => 'display: none;']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($EditProfileFormModel, 'name')->textInput(['value' => Html::encode($userProfile->name)]); ?>
        </div>

        <div class="half-wrapper">
            <div class="form-group">
                <?= $form->field($EditProfileFormModel, 'email', ['enableAjaxValidation' => true])->input('email', ['value' => Html::encode($userProfile->email)]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($EditProfileFormModel, 'bd', ['enableAjaxValidation' => true])->input('date', ['placeholder' => 'гггг-мм-дд', 'value' => Html::encode($userProfile->profile->bd)]) ?>
            </div>
        </div>

        <div class="half-wrapper">
            <div class="form-group">
                <?= $form->field($EditProfileFormModel, 'phone')->input('tel', ['value' => Html::encode($userProfile->profile->phone)]); ?>
            </div>
            <div class="form-group">
                <?= $form->field($EditProfileFormModel, 'messanger')->textInput(['value' => Html::encode($userProfile->profile->messanger)]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= $form->field($EditProfileFormModel, 'about')->textarea(['value' => Html::encode($userProfile->profile->about)]) ?>
        </div>

        <?= $form->field($EditProfileFormModel, 'categories[]', ['template' => '{label}{input}'])->checkboxList(
            ArrayHelper::map($categories, 'id', 'name'),
            [
                'separator' => '<br>',
                'item' => function ($index, $label, $name, $checked, $value) use ($EditProfileFormModel) {
                    settype($EditProfileFormModel->categories, 'array');
                    $checked = in_array($value, $EditProfileFormModel->categories) ? ' checked' : '';
                    $html = "<input type=\"checkbox\" name=\"{$name}\" value=\"{$value}\"{$checked}>";
                    $label = "<label class=\"control-label\" for=\"{$value}\">{$label}</label>";
                    return "<label>{$html}{$label}</label>";
                }
            ]
        ); ?>

        <!-- <?= print_r($userProfile); ?> -->
        <!-- <input type="submit" class="button button--blue" value="Сохранить"> -->

        <?= Html::submitInput('Сохранить', [
            'class' => 'button button--blue',
        ]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>