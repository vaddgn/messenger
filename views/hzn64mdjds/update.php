<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Messages $model */
use app\assets\AdminAsset;
AdminAsset::register($this);
$this->title = 'Update Messages: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="defaultContainer">

<div class="content">

<div class="messages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>