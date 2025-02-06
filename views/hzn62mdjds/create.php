<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

use app\assets\AdminAsset;
AdminAsset::register($this);

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="defaultContainer">
    <div class="content">
        <div class="user-create">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

</div>

    </div>
</div>

