<?php use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exception Exception */
use app\assets\ProfileAsset;
ProfileAsset::register($this);
$this->title = $exception->statusCode;
?>

<div class="defaultContainer">
    <div class="contentInfo">
        <div>
        <h1>Ошибка <?= Html::encode($exception->statusCode) ?></h1>
        <p><?= nl2br(Html::encode($exception->getMessage())) ?></p>
        </div>
    </div>
</div>

