<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\CustomHelpers;

// print($tasksInProgressCount);
?>

<div class="left-column">
        <h3 class="head-main"><?= Html::encode($user->name) ?></h3>
        <div class="user-card">
            <div class="photo-rate">
                <img class="card-photo" src="<?= Html::encode($user->profile->avatar_link) ?>" width="191" height="190" alt="Фото пользователя">
                <div class="card-rate">
                    <div class="stars-rating big">
                        <?= CustomHelpers::getRatingStars(Html::encode($user->profile->average_rating)) ?>
                    </div>
                    <span class="current-rate"><?= Html::encode($user->profile->average_rating) ?></span>
                </div>
            </div>
            <p class="user-description">
            <?= Html::encode($user->profile->about) ?>
            </p>
        </div>
        <div class="specialization-bio">
            <div class="specialization">
                <p class="head-info">Специализации</p>
                <ul class="special-list">
                <?php foreach ($specializations as $specialization) : ?>
                    <li class="special-item">
                        <a href="#" class="link link--regular"><?= Html::encode($specialization->specialization->name) ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>, <span class="town-info">Петербург</span>, <span class="age-info">30</span> лет</p>
            </div>
        </div>
        <h4 class="head-regular">Отзывы заказчиков</h4>
        <div class="response-card">
            <img class="customer-photo" src="img/man-coat.png" width="120" height="127" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                    будущем, если возникнет такая необходимость!»</p>
                <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
            </div>
            <div class="feedback-wrapper">
                <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <p class="info-text"><span class="current-time">25 минут </span>назад</p>
            </div>
        </div>
        <div class="response-card">
            <img class="customer-photo" src="img/man-sweater.png" width="120" height="127" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                    будущем, если возникнет такая необходимость!»</p>
                <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
            </div>
            <div class="feedback-wrapper">
                <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <p class="info-text"><span class="current-time">25 минут </span>назад</p>
            </div>
        </div>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                    <dt>Всего заказов</dt>
                    <dd><?= Html::encode($tasksFinishedCount) ?> выполнено, <?= Html::encode($tasksFailedCount) ?> провалено</dd>
                    <dt>Место в рейтинге</dt>
                    <dd><?= Html::encode($userRatingPosition) ?> место</dd>
                    <dt>Дата регистрации</dt>
                    <dd><?= CustomHelpers::getRuDate(Html::encode($user->dt_add)) ?></dd>
                    <dt>Статус</dt>
                    <dd><?= Html::encode($tasksInProgressCount) ? 'Выполняет активный заказ' : 'Открыт для новых заказов' ?></dd>
            </dl>
        </div>
        <div class="right-card white">
            <h4 class="head-card">Контакты</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--phone">+7 (906) 256-06-08</a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--email">super-pavel@mail.ru</a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg">@superpasha</a>
                </li>
            </ul>
        </div>
    </div>