<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Conversation $model */

use app\assets\AdminAsset;
AdminAsset::register($this);
$this->title = 'Update Conversation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conversations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="defaultContainer">
    <div class="content">



    <div class="conversation-update">

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>

    
    </div>
</div>


