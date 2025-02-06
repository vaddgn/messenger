<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\LoginAsset;
LoginAsset::register($this);
$this->title = 'Вход в аккаунт';
?>


<div class="container p-0 container-fluid d-flex justify-content-center align-items-center h-100">
<div class="loginContainer w-100" id="loginContainer">
<h1 class="titlePage"><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model_login, 'email')->textInput(['placeholder' => 'Введите ваш email'])->label($model_login->getAttributeLabel('email')) ?>

<?= $form->field($model_login, 'password')->passwordInput(['placeholder' => 'Введите ваш пароль'])->label($model_login->getAttributeLabel('password')) ?>

<div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'id' => 'rigistrSubmit']) ?>
</div>  

<?php ActiveForm::end(); ?>
<p>Нет аккаунта? <a href="#" id="registrButton">Регистрация</a></p>
</div>



<div class="registrationContainer" id="registrationContainer">
<h1 id="h1Page"><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model_registration, 'username')->textInput(['placeholder' => 'Ваше имя'])->label($model_registration->getAttributeLabel('username')) ?>

<?= $form->field($model_registration, 'userId')->textInput(['placeholder' => 'Уникальный ID'])->label($model_registration->getAttributeLabel('userId')) ?>

<?= $form->field($model_registration, 'email')->textInput(['placeholder' => 'Введите ваш email'])->label($model_registration->getAttributeLabel('email')) ?>

<?= $form->field($model_registration, 'password')->passwordInput(['placeholder' => 'Введите ваш пароль'])->label($model_registration->getAttributeLabel('password')) ?>

<?= $form->field($model_registration, 'passwordConfirm')->passwordInput(['placeholder' => 'Подтверждение пароля'])->label($model_registration->getAttributeLabel('passwordConfirm')) ?>
<div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
<p>Есть аккаунт? <a href="#" id="loginButton">Авторизация</a></p>
</div>


</div>
<canvas id="myCanvas"></canvas>

