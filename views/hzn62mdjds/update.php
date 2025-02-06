<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

use app\assets\AdminAsset;
AdminAsset::register($this);

$this->title = 'Update User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="defaultContainer">
    <div class="content">
    <div class="user-update">

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>
    </div>
</div>


