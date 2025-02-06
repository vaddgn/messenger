<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\ProfileAsset;

use function PHPUnit\Framework\isObject;

ProfileAsset::register($this);
$this->title = 'Поиск собеседника';
?>


<div class="defaultContainer">
<h1 class="titlePage"><?= Html::encode($this->title) ?></h1>
<div class="contentInfo ">

<?php $form = ActiveForm::begin(['options' => ['class' => 'formInfoSearch',],]); ?>

                
    <div class="searchContainer">
        <div class="searchInputContainer">
        <?= $form->field($model, 'userId')->textInput(['placeholder' => 'Введите ID пользователя', 'value' => Yii::$app->session->get('request')])->label(false)?>
    <div class="form-group">
        <?= Html::submitButton('Поиск', ['name' => 'action', 'value' => 'searchUser', 'class' => 'btn btn-primary']) ?>
    </div>

    <?php

    if (isset($users[0])):
        foreach ($users as $user):?> 
        <?php
            if ($user['user_id'] == $this->params['user']->user_id) :
                continue;
            endif;
        ?>

        <div class="userField">


        <img src="\messenger\web\<?=$user['profile_photo']?>" class="imguserFiled">
        <div class="userFieldInfo">
            <p><?=$user['username']?></p>
            <p class="userFieldInfoId">@<?=$user['user_id']?></p>

        </div>
        <div class="userFieldInfoButton">
            <div class="form-group submitDescription">
                <?= Html::submitButton('<i class="bi bi-person-square"></i>', ['name' => 'userInfo', 'value' => $user['user_id'], 'class' => 'btn btn-primary userInfo']) ?>
            </div>

            <div class="form-group submitDescription">
                <?= Html::a('<i class="bi bi-chat-dots-fill"></i>', ['/profile/', 'id' => $user['user_id']], ['class' => 'btn btn-primary']) ?>
            </div>

            </div>
        </div>






        <?php endforeach;
    endif;?>

    </div>

    </div>
    <div class="exitUserContainer"><i class="bi bi-x-lg"></i></div>
    <div class="userContainer">
    <?php
    if (isObject($userInfo) && isset($userInfo->user_id)):?>


        <div class="userContent">
        <div class="imageContainerSearch" id="imageContainer">
            <img id="imagePhoto" src="\messenger\web\<?=$userInfo->profile_photo?>">
        </div>

        <h2 class="usernameSearch">Имя: <?=$userInfo->username?></h2>
        <p class="userIdSearch">Уникальный ID: @<?=$userInfo->user_id?></p>
        </div>



    <?php endif;?>

    </div>

<?php ActiveForm::end(); ?>

</div>
</div>


