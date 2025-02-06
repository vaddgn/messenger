<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Messages $model */
use app\assets\AdminAsset;
AdminAsset::register($this);
$this->title = 'Create Messages';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="defaultContainer">
<div class="content">



<div class="messages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

</div>
</div>