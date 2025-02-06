<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<main id="main" class="flex-shrink-0" role="main">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>

</main>
<div class="blackBackground" id="blackBackground"></div>
<div class="leftMenu" id="leftMenu">
<div class="openMenuButton" id="userAccount">
        <div class="menuItem" id="userAccountmenuItem">
            <a href="/messenger/web/profile/info"><img id="profile_photo" src="\messenger\web\<?= $this->params['user']->profile_photo?>">
        <a href="/messenger/web/profile/info">
        <div class="textItem userText">
            <p id="username"><?= $this->params['user']->username ?></p>
            <p id="userId">@<?= $this->params['user']->user_id ?></p>
        </div>
        </a>
        </div>
    </div>
    <div class="openMenuButton">
        <div class="menuItem">
            <a href="/messenger/web/profile/" class="elementMenu iconMenu"><i class="bi bi-chat-dots"></i></a>
            <a href="/messenger/web/profile/" class="textItem elementMenu">Чаты</a>
        </div>
    </div>
    <div class="openMenuButton" id="search">
        <div class="menuItem">
            <a href="/messenger/web/profile/search" class="elementMenu iconMenu"><i class="bi bi-search"></i></a>
            <a href="/messenger/web/profile/search" class="textItem elementMenu">Новый чат</a>
        </div>
    </div>
    <div class="openMenuButton">
        <div class="menuItem">
            <a href="/messenger/web/profile/news" class="elementMenu iconMenu"><i class="bi bi-info-circle"></i></a>
            <a href="/messenger/web/profile/news" class="textItem elementMenu">О проекте</a>
        </div>
    </div>





</div>

<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <div class="alert alert-<?= $key ?>">
        <?= $message ?>
    </div>
<?php endforeach; ?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
