<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\ProfileAsset;
ProfileAsset::register($this);
$this->title = 'Настройки профиля';
?>



    <div class="defaultContainer">
        <h1 class="titlePage"><?= Html::encode($this->title) ?></h1>
            <div class="content">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data', 'class' => 'formInfo',],
                ]); ?>
                    <div class="avatar">
                        <div class="imageContainer" id="imageContainer">
                            <img id="imagePhoto" src="\messenger\web\<?=$this->params['user']->profile_photo?>">
                        </div>
                        <div class="avatarButton">
                            <div class="updateAvatar">
                            <?= $form->field($model, 'avatarFile')->fileInput(['class' => 'form-control downloadInput'])->label(false) ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Загрузить фото', ['name' => 'action', 'value' => 'updatePhoto', 'class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        <div class="form-group">
                        <?= Html::submitButton('Удалить фото', ['name' => 'action', 'value' => 'deletePhoto', 'class' => 'btn btn-danger']) ?>
                        </div>
                        </div>
                    </div>
                <div class="descriptionUser">
                <div class="form-group">
                    <label>Ваше имя: <?= Html::encode($model->username) ?></label>
                    <?= $form->field($model, 'username')->textInput()->label(false) ?>
                </div>

                <div class="form-group">
                    <label>Ваш уникальный ID: <?= Html::encode($model->user_id) ?></label>
                    <?= $form->field($model, 'user_id')->textInput()->label(false) ?>
                </div>

                <div class="form-group">
                    <label>Ваша почта: <?= Html::encode($model->email) ?></label>
                    <?= $form->field($model, 'email')->input('email')->label(false) ?>
                </div>

      
                <div class="form-group">
                    <label>Новый пароль:</label>
                    <?= $form->field($model, 'new_password')->passwordInput()->label(false) ?>
                </div>

                <div class="form-group">
                    <label>Подтверждение нового пароля:</label>
                    <?= $form->field($model, 'confirm_password')->passwordInput()->label(false) ?>
                </div>

                <div class="form-group submitDescription">
                    <?= Html::submitButton('Обновить информацию', ['name' => 'action', 'value' => 'updateInfo', 'class' => 'btn btn-primary']) ?>
                </div>

                <div class="form-group submitDescription">
                    <?= Html::submitButton('Выйти из аккаунта', ['name' => 'action', 'value' => 'exitUser', 'class' => 'btn btn-danger exitButton']) ?>
                </div>

                </div>
                <?php ActiveForm::end(); ?>
            </div>
    </div>    




