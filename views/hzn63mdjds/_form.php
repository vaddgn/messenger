<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Conversation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="conversation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'participant_one_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'participant_two_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
