<?php

use yii\bootstrap4\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use TaskForce\utils\CustomHelpers;
use yii\widgets\Menu;

AppAsset::register($this);
$user = CustomHelpers::checkAuthorization();

if ($user) {
    $userName = $user->name;
    $userProfile = CustomHelpers::getUserProfile($user->id);
} else {
    $userName = 'Анонимный пользователь';
}
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>

<body>
    <?php $this->beginBody(); ?>

    <header class="page-header">
        <nav class="main-nav">
            <a href='<?= Url::to('/') ?>' class="header-logo">
                <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
            </a>
            <?php if (Yii::$app->request->url !== Url::to(['site/registration'])) : ?>
                <div class="nav-wrapper">
                    <?php
                    $items = [
                        ['label' => 'Новое', 'url' => ['/tasks/index']],
                        ['label' => 'Мои задания', 'url' => ['/mytasks/index']],
                        ['label' => 'Настройки', 'url' => ['user/edit', 'page' => 'profile']]
                    ];

                    if ($user->role === 0) {
                        $addItem = ['label' => 'Создать задание', 'url' => ['/tasks/add']];
                        array_splice($items, 2, 0, array($addItem));
                    }
                    ?>

                    <?= Menu::widget([
                        'items' => $items,
                        'activeCssClass' => 'list-item--active',
                        'itemOptions' => ['class' => 'list-item'],
                        'labelTemplate' => '<a class="link link--nav">{label}</a>',
                        'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
                        'options' => ['class' => 'nav-list']
                    ]);
                    ?>
                </div>
            <?php endif; ?>
        </nav>

        <?php if (Yii::$app->request->url !== Url::to(['site/registration'])) : ?>
            <div class="user-block">
                <a href="#">
                    <img class="user-photo" src="<?= Url::to($userProfile->avatar_link); ?>" width="55" height="55" alt="Аватар">
                </a>
                <div class="user-menu">
                    <p class="user-name"><?= $userName ?></p>
                    <div class="popup-head">
                        <ul class="popup-menu">
                            <?= Menu::widget([
                                'items' => [
                                    ['label' => 'Настройки', 'url' => ['user/edit', 'page' => 'profile']],
                                    ['label' => 'Связаться с нами', 'url' => ['/']],
                                    ['label' => 'Выход из системы', 'url' => ['/site/logout']]
                                ],
                                'itemOptions' => ['class' => 'menu-item'],
                                'linkTemplate' => '<a href="{url}" class="link">{label}</a>',
                                'options' => ['class' => 'popup-menu']
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </header>

    <main class="main-content container">
        <?= $content ?>
    </main>

    <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>